<?php

namespace App\Http\Controllers;

use App\Models\InpatientAdmission;
use App\Models\InpatientDailyLog;
use App\Models\VitalSign;
use App\Models\Doctor;
use App\Models\Nurse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InpatientDailyLogController extends Controller
{
    public function index(InpatientAdmission $inpatient)
    {
        $logs = $inpatient->catatanHarian()
            ->with(['dokter.user', 'perawat.user', 'tandaVital'])
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('inpatient.daily-logs.index', compact('inpatient', 'logs'));
    }

    public function create(InpatientAdmission $inpatient)
    {
        $doctors = Doctor::with('user')->get();
        $nurses = Nurse::with('user')->get();
        $vitalSigns = VitalSign::where('pasien_id', $inpatient->pasien_id)
            ->where('rawat_inap_id', $inpatient->id)
            ->latest()
            ->get();

        return view('inpatient.daily-logs.create', compact('inpatient', 'doctors', 'nurses', 'vitalSigns'));
    }

    public function store(Request $request, InpatientAdmission $inpatient)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:doctor_visit,nurse_monitoring,procedure,observation',
            'dokter_id' => 'nullable|exists:dokter,id',
            'perawat_id' => 'nullable|exists:perawat,id',
            'tanda_vital_id' => 'nullable|exists:tanda_vital,id',
            'catatan' => 'nullable|string',
            'catatan_dokter' => 'nullable|string',
            'catatan_perawat' => 'nullable|string',
        ]);

        $validated['rawat_inap_id'] = $inpatient->id;

        InpatientDailyLog::create($validated);

        return redirect()->route('inpatient.daily-logs.index', $inpatient)
            ->with('success', 'Daily log berhasil ditambahkan');
    }

    public function show(InpatientAdmission $inpatient, InpatientDailyLog $log)
    {
        $log->load(['dokter.user', 'perawat.user', 'tandaVital']);

        return view('inpatient.daily-logs.show', compact('inpatient', 'log'));
    }

    public function edit(InpatientAdmission $inpatient, InpatientDailyLog $log)
    {
        $doctors = Doctor::with('user')->get();
        $nurses = Nurse::with('user')->get();
        $vitalSigns = VitalSign::where('pasien_id', $inpatient->pasien_id)
            ->where('rawat_inap_id', $inpatient->id)
            ->latest()
            ->get();

        return view('inpatient.daily-logs.edit', compact('inpatient', 'log', 'doctors', 'nurses', 'vitalSigns'));
    }

    public function update(Request $request, InpatientAdmission $inpatient, InpatientDailyLog $log)
    {
        $validated = $request->validate([
            'log_date' => 'required|date',
            'type' => 'required|in:doctor_visit,nurse_monitoring,procedure,observation',
            'doctor_id' => 'nullable|exists:doctors,id',
            'nurse_id' => 'nullable|exists:nurses,id',
            'vital_sign_id' => 'nullable|exists:vital_signs,id',
            'progress_notes' => 'nullable|string',
            'doctor_orders' => 'nullable|string',
            'nurse_notes' => 'nullable|string',
        ]);

        $log->update($validated);

        return redirect()->route('inpatient.daily-logs.index', $inpatient)
            ->with('success', 'Daily log berhasil diupdate');
    }

    public function destroy(InpatientAdmission $inpatient, InpatientDailyLog $log)
    {
        $log->delete();

        return redirect()->route('inpatient.daily-logs.index', $inpatient)
            ->with('success', 'Daily log berhasil dihapus');
    }
}
