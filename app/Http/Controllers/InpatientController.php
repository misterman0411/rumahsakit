<?php

namespace App\Http\Controllers;

use App\Models\InpatientAdmission;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Room;
use App\Models\Bed;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InpatientController extends Controller
{
    public function index(Request $request)
    {
        $query = InpatientAdmission::with(['pasien', 'dokter.user', 'ruangan', 'tempatTidur']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $admissions = $query->latest()->paginate(20);

        return view('inpatient.index', compact('admissions'));
    }

    public function create()
    {
        $patients = Patient::orderBy('nama')->get();
        $doctors = Doctor::with('user')->get();
        $rooms = Room::where('status', 'tersedia')->with('tempatTidur')->get();

        return view('inpatient.create', compact('patients', 'doctors', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'dokter_id' => 'required|exists:dokter,id',
            'ruangan_id' => 'required|exists:ruangan,id',
            'tempat_tidur_id' => 'required|exists:tempat_tidur,id',
            'tanggal_masuk' => 'required|date',
            'jenis_masuk' => 'required|in:darurat,elektif',
            'alasan_masuk' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $validated['status'] = 'dirawat';

            $admission = InpatientAdmission::create($validated);

            // Update bed status
            Bed::find($validated['tempat_tidur_id'])->update(['status' => 'terisi']);

            DB::commit();

            return redirect()->route('inpatient.show', $admission)
                ->with('success', 'Pasien berhasil dirawat inap dengan nomor: ' . $admission->nomor_rawat_inap);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal merawat inap pasien: ' . $e->getMessage())->withInput();
        }
    }

    public function show(InpatientAdmission $inpatient)
    {
        $inpatient->load(['pasien', 'dokter.user', 'ruangan', 'tempatTidur', 'tagihan']);

        return view('inpatient.show', compact('inpatient'));
    }

    public function discharge(Request $request, InpatientAdmission $inpatient)
    {
        $validated = $request->validate([
            'tanggal_keluar' => 'required|date|after_or_equal:tanggal_masuk',
            'resume_keluar' => 'required|string',
            'instruksi_pulang' => 'nullable|string',
            'tanggal_kontrol' => 'nullable|date|after:tanggal_keluar',
            'status_pulang' => 'required|in:sembuh,dirujuk,meninggal,aps',
            'diskon' => 'nullable|numeric|min:0',
            'pajak' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $validated['status'] = 'pulang';
            $validated['diskon'] = $validated['diskon'] ?? 0;
            $validated['pajak'] = $validated['pajak'] ?? 0;

            $inpatient->update($validated);

            // Update bed status
            $inpatient->tempatTidur->update(['status' => 'tersedia']);

            // Calculate total cost
            $totalCost = $inpatient->calculateTotalCost();

            // Create invoice
            $invoice = Invoice::create([
                'pasien_id' => $inpatient->pasien_id,
                'tagihan_untuk_id' => $inpatient->id,
                'tagihan_untuk_tipe' => InpatientAdmission::class,
                'subtotal' => $totalCost + $validated['diskon'] - $validated['pajak'],
                'diskon' => $validated['diskon'],
                'pajak' => $validated['pajak'],
                'total' => $totalCost,
                'status' => 'belum_dibayar',
                'jatuh_tempo' => now()->addDays(7),
            ]);

            // Create invoice items from inpatient charges
            $charges = $inpatient->biayaRawatInap;
            foreach ($charges as $charge) {
                $invoice->itemTagihan()->create([
                    'deskripsi' => $charge->deskripsi . ' (' . ucfirst($charge->jenis_biaya) . ')',
                    'jumlah' => $charge->jumlah,
                    'harga_satuan' => $charge->harga_satuan,
                    'total' => $charge->total,
                ]);
            }

            DB::commit();

            return redirect()->route('inpatient.show', $inpatient)
                ->with('success', 'Pasien berhasil dipulangkan. Invoice telah dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memulangkan pasien: ' . $e->getMessage())->withInput();
        }
    }
}
