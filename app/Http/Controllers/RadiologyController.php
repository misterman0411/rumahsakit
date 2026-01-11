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
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load('peran');
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
        $radiology->load([
            'pasien', 
            'dokter.user', 
            'jenisTes', 
            'tagihan',
            'hasilDiinputOleh.peran',
            'signedBy.peran',
            'revisions.hasilDiinputOleh.peran',
            'revisions.signedBy.peran',
            'parentRevision'
        ]);

        /** @var \App\Models\User $currentUser */
        $currentUser = Auth::user();
        $currentUser->load('peran');

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
            'image' => 'nullable|file|mimes:jpg,jpeg,png,dcm,dicom|max:10240', // 10MB max
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('radiology_images', 'public');
            $validated['image_path'] = $path;
        }

        // Save as draft by default
        $validated['status'] = 'sedang_diproses';
        $validated['report_status'] = 'draft';
        $validated['hasil_diinput_oleh'] = Auth::id();
        $validated['waktu_input_hasil'] = now();

        $radiology->update($validated);

        return redirect()->route('radiology.show', $radiology)
            ->with('success', 'Hasil radiologi berhasil disimpan sebagai draft');
    }

    public function finalizeReport(RadiologyOrder $radiology)
    {
        // Can only finalize draft reports
        if ($radiology->report_status !== 'draft') {
            return redirect()->back()->with('error', 'Hanya laporan draft yang dapat difinalisasi');
        }

        $radiology->update([
            'status' => 'selesai',
            'report_status' => 'final',
            'signed_by' => Auth::id(),
            'signed_at' => now(),
        ]);

        return redirect()->route('radiology.show', $radiology)
            ->with('success', 'Laporan radiologi berhasil difinalisasi dan ditandatangani');
    }

    public function createRevision(Request $request, RadiologyOrder $radiology)
    {
        // Can only revise finalized reports
        if ($radiology->report_status !== 'final') {
            return redirect()->back()->with('error', 'Hanya laporan final yang dapat direvisi');
        }

        $validated = $request->validate([
            'hasil' => 'required|string',
            'interpretasi' => 'required|string',
            'revision_reason' => 'required|string|min:10',
        ]);

        // Create new revision
        $revision = $radiology->replicate();
        $revision->nomor_permintaan = null; // Will be auto-generated
        $revision->parent_revision_id = $radiology->id;
        $revision->version = $radiology->version + 1;
        $revision->hasil = $validated['hasil'];
        $revision->interpretasi = $validated['interpretasi'];
        $revision->report_status = 'draft';
        $revision->signed_by = null;
        $revision->signed_at = null;
        $revision->hasil_diinput_oleh = Auth::id();
        $revision->waktu_input_hasil = now();
        
        // Generate new order number for revision
        $date = now()->format('Ymd');
        $lastOrder = RadiologyOrder::whereDate('created_at', today())
            ->orderBy('nomor_permintaan', 'desc')
            ->first();
        
        if ($lastOrder && preg_match('/-(\d+)$/', $lastOrder->nomor_permintaan, $matches)) {
            $nextNumber = intval($matches[1]) + 1;
        } else {
            $nextNumber = 1;
        }
        
        $revision->nomor_permintaan = 'RAD-' . $date . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        $revision->save();

        // Add revision note to catatan_klinis
        $radiology->update([
            'catatan_klinis' => ($radiology->catatan_klinis ?? '') . "\n\n[REVISI v{$revision->version}] " . $validated['revision_reason']
        ]);

        return redirect()->route('radiology.show', $revision)
            ->with('success', 'Revisi laporan berhasil dibuat (Versi ' . $revision->version . ')');
    }

    public function print(RadiologyOrder $radiology)
    {
        $radiology->load([
            'pasien',
            'dokter.user',
            'jenisTes',
            'hasilDiinputOleh.peran',
            'signedBy.peran',
            'parentRevision'
        ]);

        return view('radiology.print', compact('radiology'));
    }
}
