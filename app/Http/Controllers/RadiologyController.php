<?php

namespace App\Http\Controllers;

use App\Models\RadiologyOrder;
use App\Models\RadiologyTestType;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Invoice;
use Illuminate\Http\Request;

class RadiologyController extends Controller
{
    public function index(Request $request)
    {
        $query = RadiologyOrder::with(['pasien', 'dokter.user', 'jenisTes']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(20);

        return view('radiology.index', compact('orders'));
    }

    public function create()
    {
        $patients = Patient::orderBy('nama')->get();
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

        // Model will auto-generate nomor_permintaan via boot() method
        $order = RadiologyOrder::create($validated);

        // Create invoice (model will auto-generate nomor_tagihan)
        $testType = RadiologyTestType::find($validated['jenis_tes_id']);
        $invoice = Invoice::create([
            'pasien_id' => $order->pasien_id,
            'tagihan_untuk_id' => $order->id,
            'tagihan_untuk_tipe' => RadiologyOrder::class,
            'subtotal' => $testType->harga,
            'diskon' => 0,
            'pajak' => 0,
            'total' => $testType->harga,
            'status' => 'belum_dibayar',
            'jatuh_tempo' => now()->addDays(7),
        ]);

        // Create invoice item for radiology test
        $invoice->itemTagihan()->create([
            'deskripsi' => 'Test Radiologi - ' . $testType->nama,
            'jumlah' => 1,
            'harga_satuan' => $testType->harga,
            'total' => $testType->harga,
        ]);

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
            'status' => 'scheduled',
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
