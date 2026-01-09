<?php

namespace App\Http\Controllers;

use App\Models\LaboratoryOrder;
use App\Models\LaboratoryResult;
use App\Models\LabTestType;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaboratoryController extends Controller
{
    public function index(Request $request)
    {
        $query = LaboratoryOrder::with(['pasien', 'dokter.user', 'jenisTes', 'hasilLaboratorium']);

        // Filter berdasarkan role user
        $user = Auth::user();
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
        $user = Auth::user();
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

        $order = LaboratoryOrder::create($validated);

        // Create invoice
        $testType = LabTestType::find($validated['jenis_tes_id']);
        $invoice = Invoice::create([
            'pasien_id' => $order->pasien_id,
            'tagihan_untuk_id' => $order->id,
            'tagihan_untuk_tipe' => LaboratoryOrder::class,
            'subtotal' => $testType->harga,
            'diskon' => 0,
            'pajak' => 0,
            'total' => $testType->harga,
            'status' => 'belum_dibayar',
            'jatuh_tempo' => now()->addDays(7),
        ]);

        // Create invoice item for lab test
        $invoice->itemTagihan()->create([
            'deskripsi' => 'Test Laboratorium - ' . $testType->nama,
            'jumlah' => 1,
            'harga_satuan' => $testType->harga,
            'total' => $testType->harga,
        ]);

        return redirect()->route('laboratory.show', $order)
            ->with('success', 'Order laboratorium berhasil dibuat dengan nomor: ' . $order->nomor_permintaan);
    }

    public function show(LaboratoryOrder $laboratory)
    {
        $laboratory->load(['pasien', 'dokter.user', 'jenisTes', 'hasilLaboratorium', 'tagihan']);

        return view('laboratory.show', compact('laboratory'));
    }

    public function collectSample(LaboratoryOrder $laboratory)
    {
        $laboratory->update([
            'status' => 'sampel_diambil',
            'sample_collected_at' => now(),
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
                'diperiksa_oleh' => auth()->id,
                'waktu_pemeriksaan' => now(),
            ]);
        }

        $laboratory->update(['status' => 'sedang_diproses']);

        return redirect()->route('laboratory.show', $laboratory)
            ->with('success', 'Hasil laboratorium berhasil diinput');
    }

    public function verify(LaboratoryOrder $laboratory)
    {
        $laboratory->update([
            'status' => 'selesai',
        ]);

        return redirect()->route('laboratory.show', $laboratory)
            ->with('success', 'Hasil laboratorium berhasil diverifikasi');
    }
}
