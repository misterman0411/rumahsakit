<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Medication;
use App\Models\Invoice;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PrescriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Prescription::with(['pasien', 'dokter.user', 'itemResep.obat']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $prescriptions = $query->latest()->paginate(20);

        return view('prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
        $patients = Patient::orderBy('nama')->get();
        $doctors = Doctor::with('user')->get();
        $medications = Medication::where('stok', '>', 0)->orderBy('nama')->get();

        return view('prescriptions.create', compact('patients', 'doctors', 'medications'));
    }

    public function store(Request $request)
    {
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
            $validated['status'] = 'pending';
            $prescription = Prescription::create([
                'pasien_id' => $validated['pasien_id'],
                'dokter_id' => $validated['dokter_id'],
                'catatan' => $validated['catatan'] ?? null,
                'status' => 'pending',
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
                    'harga' => $totalPrice,
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
                'status' => 'unpaid',
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
        $prescription->load(['patient', 'doctor.user', 'items.medication', 'invoice']);

        return view('prescriptions.show', compact('prescription'));
    }

    public function verify(Prescription $prescription)
    {
        $prescription->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        return redirect()->route('prescriptions.show', $prescription)
            ->with('success', 'Resep berhasil diverifikasi');
    }

    public function dispense(Prescription $prescription)
    {
        DB::beginTransaction();
        try {
            // Check stock availability
            foreach ($prescription->items as $item) {
                if ($item->medication->stock_quantity < $item->quantity) {
                    throw new \Exception("Stok {$item->medication->name} tidak mencukupi. Tersedia: {$item->medication->stock_quantity}, Dibutuhkan: {$item->quantity}");
                }
            }

            // Reduce stock and record movement
            foreach ($prescription->items as $item) {
                StockMovement::recordMovement(
                    $item->medication,
                    'out',
                    $item->quantity,
                    Prescription::class,
                    $prescription->id,
                    "Dispensed prescription {$prescription->prescription_number} for patient {$prescription->patient->name}"
                );
            }

            $prescription->update([
                'status' => 'dispensed',
                'dispensed_at' => now(),
                'dispensed_by' => Auth::id(),
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
