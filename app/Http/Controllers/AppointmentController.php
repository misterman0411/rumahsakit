<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Invoice;
use App\Models\ServiceCharge;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['pasien', 'dokter.user', 'departemen']);

        // Filter berdasarkan role user
        $user = Auth::user();
        $role = $user->peran->nama ?? null;

        if ($role === 'doctor') {
            // Jika login sebagai dokter, hanya tampilkan appointment dokter tersebut
            $doctor = Doctor::where('user_id', $user->id)->first();
            if ($doctor) {
                $query->where('dokter_id', $doctor->id);
            }
        } elseif ($role === 'nurse') {
            // Jika login sebagai perawat, bisa filter berdasarkan departemen jika perlu
            // (bisa disesuaikan dengan kebutuhan)
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_janji_temu', 'like', "%{$search}%")
                  ->orWhereHas('pasien', function ($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhereHas('dokter.user', function ($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('tanggal_janji', $request->date);
        }

        $appointments = $query->latest('tanggal_janji')->paginate(20);

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::orderBy('nama')->get();
        $doctors = Doctor::with('user', 'departemen')->get();
        $departments = Department::orderBy('nama')->get();

        return view('appointments.create', compact('patients', 'doctors', 'departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'dokter_id' => 'required|exists:dokter,id',
            'departemen_id' => 'required|exists:departemen,id',
            'tanggal_janji' => 'required|date',
            'waktu_janji' => 'required',
            'jenis' => 'required|in:rawat_jalan,darurat,rawat_inap,kontrol_ulang',
            'alasan' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        // Combine date and time
        $validated['tanggal_janji'] = $validated['tanggal_janji'] . ' ' . $validated['waktu_janji'];
        unset($validated['waktu_janji']);

        $validated['status'] = 'terjadwal';

        // Create or find active visit for this patient
        $visit = Visit::firstOrCreate(
            [
                'pasien_id' => $validated['pasien_id'],
                'tanggal_kunjungan' => now()->format('Y-m-d'),
                'status' => 'aktif',
            ],
            [
                'jenis_kunjungan' => $validated['jenis'] === 'rawat_inap' ? 'rawat_inap' : 'rawat_jalan',
                'keluhan_utama' => $validated['alasan'],
            ]
        );

        $validated['kunjungan_id'] = $visit->id;
        $appointment = Appointment::create($validated);

        // Get or create invoice for this visit
        $invoice = Invoice::firstOrNew([
            'kunjungan_id' => $visit->id,
            'pasien_id' => $appointment->pasien_id,
        ]);

        // If invoice is new, set initial values
        if (!$invoice->exists) {
            $invoice->fill([
                'tagihan_untuk_id' => $appointment->id,
                'tagihan_untuk_tipe' => Appointment::class,
                'subtotal' => 0,
                'diskon' => 0,
                'pajak' => 0,
                'total' => 0,
                'status' => 'belum_dibayar',
                'jatuh_tempo' => now()->addDays(7),
            ]);
            $invoice->save();
        }

        // Add consultation fee to invoice
        $doctor = Doctor::find($validated['dokter_id']);
        $consultationFee = ServiceCharge::where('kode', 'CONSULT')->first();
        $feeAmount = $consultationFee->harga ?? $doctor->biaya_konsultasi;
        
        $invoice->itemTagihan()->create([
            'deskripsi' => 'Biaya Konsultasi - ' . $doctor->user->name,
            'jumlah' => 1,
            'harga_satuan' => $feeAmount,
            'total' => $feeAmount,
        ]);

        // Update invoice totals
        $invoice->subtotal += $feeAmount;
        $invoice->total += $feeAmount;
        $invoice->save();

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment berhasil dibuat dengan nomor: ' . $appointment->nomor_janji_temu);
    }

    public function show(Appointment $appointment)
    {
        $appointment->load([
            'pasien',
            'dokter.user',
            'departemen',
            'rekamMedis',
            'tagihan',
        ]);

        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::orderBy('nama')->get();
        $doctors = Doctor::with('user', 'departemen')->get();
        $departments = Department::orderBy('nama')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors', 'departments'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'dokter_id' => 'required|exists:dokter,id',
            'departemen_id' => 'required|exists:departemen,id',
            'tanggal_janji' => 'required|date',
            'jenis' => 'required|in:rawat_jalan,darurat,rawat_inap,kontrol_ulang',
            'status' => 'required|in:terjadwal,dikonfirmasi,check_in,sedang_dilayani,selesai,dibatalkan,tidak_hadir',
            'alasan' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment berhasil diperbarui');
    }

    public function checkIn(Appointment $appointment)
    {
        // Generate queue number
        $todayCheckedIn = Appointment::whereDate('tanggal_janji', $appointment->tanggal_janji)
            ->where('departemen_id', $appointment->departemen_id)
            ->whereNotNull('nomor_antrian')
            ->count();
        
        $queueNumber = $todayCheckedIn + 1;
        $queueCode = strtoupper(substr($appointment->departemen->nama ?? 'A', 0, 1)) 
                   . str_pad($queueNumber, 3, '0', STR_PAD_LEFT);

        $appointment->update([
            'status' => 'check_in',
            'waktu_check_in' => now(),
            'nomor_antrian' => $queueNumber,
            'kode_antrian' => $queueCode,
        ]);

        return redirect()->route('appointments.show', $appointment)
            ->with('success', "Pasien berhasil check-in. Nomor Antrian: {$queueCode}");
    }

    public function confirm(Appointment $appointment)
    {
        if ($appointment->status !== 'terjadwal') {
            return redirect()->back()->with('error', 'Hanya appointment dengan status terjadwal yang bisa dikonfirmasi');
        }

        $appointment->update(['status' => 'dikonfirmasi']);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment berhasil dikonfirmasi');
    }

    public function cancel(Appointment $appointment)
    {
        if (in_array($appointment->status, ['selesai', 'dibatalkan'])) {
            return redirect()->back()->with('error', 'Appointment tidak bisa dibatalkan');
        }

        $appointment->update(['status' => 'dibatalkan']);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment berhasil dibatalkan');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->update(['status' => 'dibatalkan']);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment berhasil dibatalkan');
    }
}
