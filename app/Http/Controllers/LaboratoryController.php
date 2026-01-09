<?php

namespace App\Http\Controllers;

use App\Models\LaboratoryOrder;
use App\Models\LaboratoryResult;
use App\Models\LabTestType;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\MedicalRecord;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaboratoryController extends Controller
{
    public function index(Request $request)
    {
        $query = LaboratoryOrder::with(['pasien', 'dokter.user', 'jenisTes', 'hasilLaboratorium']);

        // Filter berdasarkan role user
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('peran');
        $role = $user->peran->nama ?? null;

        if ($role === 'doctor') {
            // Jika login sebagai dokter, hanya tampilkan order lab dokter tersebut
            $doctor = Doctor::where('user_id', $user->id)->first();
            if ($doctor) {
                $query->where('dokter_id', $doctor->id);
            }
        } elseif ($role === 'lab_technician') {
            // Lab technician bisa melihat semua order lab
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20);

        return view('laboratory.index', compact('orders'));
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('peran');
        $role = $user->peran->nama ?? null;
        
        // Filter pasien berdasarkan role
        if ($role === 'doctor') {
            // Hanya tampilkan pasien yang sudah pernah diperiksa oleh dokter ini
            $doctor = Doctor::where('user_id', $user->id)->first();
            if ($doctor) {
                $patients = Patient::whereHas('rekamMedis', function ($query) use ($doctor) {
                    $query->where('dokter_id', $doctor->id);
                })->orderBy('nama')->get();
            } else {
                $patients = collect(); // empty collection
            }
        } else {
            // Admin, lab technician, dll bisa lihat semua pasien
            $patients = Patient::orderBy('nama')->get();
        }
        
        $doctors = Doctor::with('user')->get();
        $testTypes = LabTestType::orderBy('nama')->get();

        return view('laboratory.create', compact('patients', 'doctors', 'testTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'dokter_id' => 'required|exists:dokter,id',
            'jenis_tes_id' => 'required|exists:jenis_tes_laboratorium,id',
            'informasi_klinis' => 'nullable|string',
        ]);

        $validated['status'] = 'menunggu';

        // Find or create visit for this patient today
        $visit = Visit::where('pasien_id', $validated['pasien_id'])
            ->whereDate('tanggal_kunjungan', today())
            ->where('status', 'aktif')
            ->first();

        if (!$visit) {
            $visit = Visit::create([
                'pasien_id' => $validated['pasien_id'],
                'tanggal_kunjungan' => now(),
                'jenis_kunjungan' => 'rawat_jalan',
                'status' => 'aktif',
            ]);
        }

        $validated['kunjungan_id'] = $visit->id;
        $order = LaboratoryOrder::create($validated);

        // Get or create invoice for this visit
        $testType = LabTestType::find($validated['jenis_tes_id']);
        
        // Find invoice for this visit that is NOT paid yet
        $invoice = Invoice::where('kunjungan_id', $visit->id)
            ->where('pasien_id', $order->pasien_id)
            ->where('status', '!=', 'lunas')
            ->first();

        // If no unpaid invoice found, create a new one
        if (!$invoice) {
            $invoice = Invoice::create([
                'kunjungan_id' => $visit->id,
                'pasien_id' => $order->pasien_id,
                'tagihan_untuk_id' => $order->id,
                'tagihan_untuk_tipe' => LaboratoryOrder::class,
                'subtotal' => 0,
                'diskon' => 0,
                'pajak' => 0,
                'total' => 0,
                'status' => 'belum_dibayar',
                'jatuh_tempo' => now()->addDays(7),
            ]);
        }

        // Add lab test to invoice
        $invoice->itemTagihan()->create([
            'deskripsi' => 'Test Laboratorium - ' . $testType->nama,
            'jumlah' => 1,
            'harga_satuan' => $testType->harga,
            'total' => $testType->harga,
        ]);

        // Update invoice totals
        $invoice->subtotal += $testType->harga;
        $invoice->total += $testType->harga;
        $invoice->save();

        return redirect()->route('laboratory.show', $order)
            ->with('success', 'Order laboratorium berhasil dibuat dengan nomor: ' . $order->nomor_permintaan);
    }

    public function show(LaboratoryOrder $laboratory)
    {
        $laboratory->load([
            'pasien',
            'dokter.user',
            'jenisTes',
            'hasilLaboratorium',
            'tagihan',
            'sampelDiambilOleh',
            'hasilDiinputOleh',
            'diverifikasiOleh'
        ]);

        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();
        $currentUser->load('peran');

        return view('laboratory.show', compact('laboratory'));
    }

    public function collectSample(LaboratoryOrder $laboratory)
    {
        $laboratory->update([
            'status' => 'sampel_diambil',
            'sample_collected_at' => now(),
            'sampel_diambil_oleh' => Auth::id(),
        ]);

        return redirect()->route('laboratory.show', $laboratory)
            ->with('success', 'Sampel berhasil diambil');
    }

    public function enterResults(Request $request, LaboratoryOrder $laboratory)
    {
        $validated = $request->validate([
            'results' => 'required|array',
            'results.*.hasil' => 'required|string',
            'results.*.nilai' => 'nullable|string',
            'results.*.satuan' => 'nullable|string',
            'results.*.nilai_rujukan' => 'nullable|string',
            'results.*.status' => 'nullable|in:normal,tinggi,rendah,kritis',
            'results.*.catatan' => 'nullable|string',
        ]);

        foreach ($validated['results'] as $result) {
            LaboratoryResult::create([
                'permintaan_id' => $laboratory->id,
                'hasil' => $result['hasil'],
                'nilai' => $result['nilai'] ?? null,
                'satuan' => $result['satuan'] ?? null,
                'nilai_rujukan' => $result['nilai_rujukan'] ?? null,
                'status' => $result['status'] ?? null,
                'catatan' => $result['catatan'] ?? null,
                'diperiksa_oleh' => Auth::id(),
                'waktu_pemeriksaan' => now(),
            ]);
        }

        $laboratory->update([
            'status' => 'sedang_diproses',
            'hasil_diinput_oleh' => Auth::id(),
            'waktu_input_hasil' => now(),
        ]);

        return redirect()->route('laboratory.show', $laboratory)
            ->with('success', 'Hasil laboratorium berhasil diinput');
    }

    public function verify(LaboratoryOrder $laboratory)
    {
        $laboratory->update([
            'status' => 'selesai',
            'diverifikasi_oleh' => Auth::id(),
            'waktu_verifikasi' => now(),
        ]);

        return redirect()->route('laboratory.show', $laboratory)
            ->with('success', 'Hasil laboratorium berhasil diverifikasi');
    }

    public function print(LaboratoryOrder $laboratory)
    {
        $laboratory->load([
            'pasien',
            'dokter.user',
            'jenisTes',
            'hasilLaboratorium',
            'sampelDiambilOleh',
            'hasilDiinputOleh',
            'diverifikasiOleh',
        ]);

        return view('laboratory.print', compact('laboratory'));
    }
}
