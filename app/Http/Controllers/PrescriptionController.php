<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Medication;
use App\Models\Invoice;
use App\Models\StockMovement;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Prescription::with(['pasien', 'dokter.user', 'itemResep.obat']);

        // Filter berdasarkan role user
        $user = Auth::user();
        $role = $user->peran->nama ?? null;

        if ($role === 'doctor') {
            // Jika login sebagai dokter, hanya tampilkan resep dokter tersebut
            $doctor = Doctor::where('user_id', $user->id)->first();
            if ($doctor) {
                $query->where('dokter_id', $doctor->id);
            }
        } elseif ($role === 'pharmacist') {
            // Pharmacist bisa melihat semua resep
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $prescriptions = $query->latest()->paginate(20);

        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
        $user = Auth::user();
        $role = $user->peran->nama ?? null;
        
        $currentDoctor = null;
        
        // Filter pasien berdasarkan role
        if ($role === 'doctor') {
            // Hanya tampilkan pasien yang sudah pernah diperiksa oleh dokter ini
            $doctor = Doctor::where('user_id', $user->id)->first();
            $currentDoctor = $doctor;
            if ($doctor) {
                $patients = Patient::whereHas('rekamMedis', function ($query) use ($doctor) {
                    $query->where('dokter_id', $doctor->id);
                })->orderBy('nama')->get();
            } else {
                $patients = collect(); // empty collection
            }
        } else {
            // Admin, pharmacist, dll bisa lihat semua pasien
            $patients = Patient::orderBy('nama')->get();
        }
        
        $doctors = Doctor::with('user')->get();
        $medications = Medication::where('stok', '>', 0)->orderBy('nama')->get();

        return view('prescriptions.create', compact('patients', 'doctors', 'medications', 'currentDoctor'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $role = $user->peran->nama ?? null;
        
        // Jika dokter, auto-set dokter_id dari user yang login
        if ($role === 'doctor') {
            $doctor = Doctor::where('user_id', $user->id)->first();
            if ($doctor) {
                $request->merge(['dokter_id' => $doctor->id]);
            }
        }
        
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'dokter_id' => 'required|exists:dokter,id',
            'catatan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.obat_id' => 'required|exists:obat,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.dosis' => 'required|string',
            'items.*.frekuensi' => 'required|string',
            'items.*.durasi' => 'required|string',
            'items.*.instruksi' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $prescription = Prescription::create([
                'pasien_id' => $validated['pasien_id'],
                'dokter_id' => $validated['dokter_id'],
                'catatan' => $validated['catatan'] ?? null,
                'status' => 'menunggu',
            ]);

            $totalAmount = 0;

            foreach ($validated['items'] as $item) {
                $medication = Medication::find($item['obat_id']);
                $totalPrice = $medication->harga * $item['jumlah'];

                PrescriptionItem::create([
                    'resep_id' => $prescription->id,
                    'obat_id' => $item['obat_id'],
                    'jumlah' => $item['jumlah'],
                    'dosis' => $item['dosis'],
                    'frekuensi' => $item['frekuensi'],
                    'durasi' => $item['durasi'],
                    'instruksi' => $item['instruksi'] ?? null,
                ]);

                $totalAmount += $totalPrice;
            }

            // Create invoice
            $invoice = Invoice::create([
                'pasien_id' => $prescription->pasien_id,
                'tagihan_untuk_id' => $prescription->id,
                'tagihan_untuk_tipe' => Prescription::class,
                'subtotal' => $totalAmount,
                'diskon' => 0,
                'pajak' => 0,
                'total' => $totalAmount,
                'status' => 'belum_dibayar',
                'jatuh_tempo' => now()->addDays(7),
            ]);

            // Create invoice items from prescription items
            foreach ($validated['items'] as $item) {
                $medication = Medication::find($item['obat_id']);
                $itemTotal = $medication->harga * $item['jumlah'];
                
                $invoice->itemTagihan()->create([
                    'deskripsi' => $medication->nama . ' - ' . $item['dosis'] . ' (' . $item['frekuensi'] . ')',
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $medication->harga,
                    'total' => $itemTotal,
                ]);
            }

            DB::commit();

            return redirect()->route('prescriptions.show', $prescription)
                ->with('success', 'Resep berhasil dibuat dengan nomor: ' . $prescription->nomor_resep);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat resep: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['pasien', 'dokter.user', 'itemResep.obat', 'tagihan']);

        return view('prescriptions.show', compact('prescription'));
    }

    public function verify(Prescription $prescription)
    {
        $prescription->update([
            'status' => 'diverifikasi',
            'waktu_verifikasi' => now(),
            'diverifikasi_oleh' => Auth::id(),
        ]);

        return redirect()->route('prescriptions.show', $prescription)
            ->with('success', 'Resep berhasil diverifikasi');
    }

    public function dispense(Prescription $prescription)
    {
        DB::beginTransaction();
        try {
            // Check stock availability
            foreach ($prescription->itemResep as $item) {
                if ($item->obat->stok < $item->jumlah) {
                    throw new \Exception("Stok {$item->obat->nama} tidak mencukupi. Tersedia: {$item->obat->stok}, Dibutuhkan: {$item->jumlah}");
                }
            }

            // Reduce stock and record movement
            foreach ($prescription->itemResep as $item) {
                StockMovement::recordMovement(
                    $item->obat,
                    'out',
                    $item->jumlah,
                    Prescription::class,
                    $prescription->id,
                    "Dispensed prescription {$prescription->nomor_resep} for patient {$prescription->pasien->nama}"
                );
            }

            $prescription->update([
                'status' => 'diserahkan',
                'waktu_diserahkan' => now(),
                'diserahkan_oleh' => Auth::id(),
            ]);

            DB::commit();

            return redirect()->route('prescriptions.show', $prescription)
                ->with('success', 'Obat berhasil diserahkan dan stok telah dikurangi');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyerahkan obat: ' . $e->getMessage());
        }
    }
}
