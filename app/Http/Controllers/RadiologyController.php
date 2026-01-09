<?php

namespace App\Http\Controllers;

use App\Models\RadiologyOrder;
use App\Models\RadiologyTestType;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Invoice;
use App\Models\MedicalRecord;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RadiologyController extends Controller
{
    public function index(Request $request)
    {
        $query = RadiologyOrder::with(['pasien', 'dokter.user', 'jenisTes']);

        // Filter berdasarkan role user
        $user = Auth::user();
        $role = $user->peran->nama ?? null;

        if ($role === 'doctor') {
            // Jika login sebagai dokter, hanya tampilkan order radiologi dokter tersebut
            $doctor = Doctor::where('user_id', $user->id)->first();
            if ($doctor) {
                $query->where('dokter_id', $doctor->id);
            }
        } elseif ($role === 'radiologist') {
            // Radiologist bisa melihat semua order radiologi
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20);

        return view('radiology.index', compact('orders'));
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
            // Admin, radiologist, dll bisa lihat semua pasien
            $patients = Patient::orderBy('nama')->get();
        }
        
        $doctors = Doctor::with('user')->get();
        $testTypes = RadiologyTestType::orderBy('nama')->get();

        return view('radiology.create', compact('patients', 'doctors', 'testTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'dokter_id' => 'required|exists:dokter,id',
            'jenis_tes_id' => 'required|exists:jenis_tes_radiologi,id',
            'catatan_klinis' => 'nullable|string',
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
        // Model will auto-generate nomor_permintaan via boot() method
        $order = RadiologyOrder::create($validated);

        // Get or create invoice for this visit (model will auto-generate nomor_tagihan)
        $testType = RadiologyTestType::find($validated['jenis_tes_id']);
        
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
                'tagihan_untuk_tipe' => RadiologyOrder::class,
                'subtotal' => 0,
                'diskon' => 0,
                'pajak' => 0,
                'total' => 0,
                'status' => 'belum_dibayar',
                'jatuh_tempo' => now()->addDays(7),
            ]);
        }

        // Add radiology test to invoice
        $invoice->itemTagihan()->create([
            'deskripsi' => 'Test Radiologi - ' . $testType->nama,
            'jumlah' => 1,
            'harga_satuan' => $testType->harga,
            'total' => $testType->harga,
        ]);

        // Update invoice totals
        $invoice->subtotal += $testType->harga;
        $invoice->total += $testType->harga;
        $invoice->save();

        return redirect()->route('radiology.show', $order)
            ->with('success', 'Order radiologi berhasil dibuat dengan nomor: ' . $order->nomor_permintaan);
    }

    public function show(RadiologyOrder $radiology)
    {
        $radiology->load(['pasien', 'dokter.user', 'jenisTes', 'tagihan']);

        return view('radiology.show', compact('radiology'));
    }

    public function schedule(Request $request, RadiologyOrder $radiology)
    {
        $validated = $request->validate([
            'scheduled_date' => 'required|date|after:now',
        ]);

        $radiology->update([
            'status' => 'sedang_diproses',
            'scheduled_date' => $validated['scheduled_date'],
        ]);

        return redirect()->route('radiology.show', $radiology)
            ->with('success', 'Pemeriksaan radiologi berhasil dijadwalkan');
    }

    public function enterInterpretation(Request $request, RadiologyOrder $radiology)
    {
        $validated = $request->validate([
            'hasil' => 'required|string',
            'interpretasi' => 'required|string',
        ]);

        $validated['status'] = 'selesai';

        $radiology->update($validated);

        return redirect()->route('radiology.show', $radiology)
            ->with('success', 'Hasil radiologi berhasil disimpan');
    }
}
