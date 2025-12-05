<?php

namespace App\Http\Controllers;

use App\Models\VitalSign;
use App\Models\Patient;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VitalSignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = VitalSign::with(['pasien', 'rekamMedis', 'dicatatOleh']);

        // Filter by patient
        if ($request->filled('pasien_id')) {
            $query->where('pasien_id', $request->pasien_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('waktu_pencatatan', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('waktu_pencatatan', '<=', $request->date_to);
        }

        $vitalSigns = $query->latest('waktu_pencatatan')->paginate(15);
        $patients = Patient::orderBy('nama')->get();

        return view('vital-signs.index', compact('vitalSigns', 'patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::where('status', 'active')->orderBy('nama')->get();
        $medicalRecords = MedicalRecord::with(['pasien', 'dokter.user'])
            ->latest()
            ->take(50)
            ->get();

        return view('vital-signs.create', compact('patients', 'medicalRecords'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'rekam_medis_id' => 'nullable|exists:rekam_medis,id',
            'tekanan_darah' => 'nullable|string|max:20',
            'suhu' => 'nullable|numeric|between:30,45',
            'detak_jantung' => 'nullable|integer|between:30,250',
            'laju_pernapasan' => 'nullable|integer|between:5,60',
            'saturasi_oksigen' => 'nullable|integer|between:50,100',
            'berat_badan' => 'nullable|numeric|between:0.5,500',
            'tinggi_badan' => 'nullable|numeric|between:20,300',
            'catatan' => 'nullable|string',
            'waktu_pencatatan' => 'nullable|date',
        ]);

        $validated['dicatat_oleh'] = Auth::id();
        $validated['waktu_pencatatan'] = $validated['waktu_pencatatan'] ?? now();

        $vitalSign = VitalSign::create($validated);

        return redirect()->route('vital-signs.show', $vitalSign)
            ->with('success', 'Vital signs recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VitalSign $vitalSign)
    {
        $vitalSign->load(['pasien', 'rekamMedis.dokter.user', 'dicatatOleh']);

        return view('vital-signs.show', compact('vitalSign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VitalSign $vitalSign)
    {
        $patients = Patient::where('status', 'active')->orderBy('nama')->get();
        $medicalRecords = MedicalRecord::with(['pasien', 'dokter.user'])
            ->where('pasien_id', $vitalSign->pasien_id)
            ->latest()
            ->take(20)
            ->get();

        return view('vital-signs.edit', compact('vitalSign', 'patients', 'medicalRecords'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VitalSign $vitalSign)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medical_record_id' => 'nullable|exists:medical_records,id',
            'blood_pressure' => 'nullable|string|max:20',
            'temperature' => 'nullable|numeric|between:30,45',
            'heart_rate' => 'nullable|integer|between:30,250',
            'respiratory_rate' => 'nullable|integer|between:5,60',
            'oxygen_saturation' => 'nullable|integer|between:50,100',
            'weight' => 'nullable|numeric|between:0.5,500',
            'height' => 'nullable|numeric|between:20,300',
            'notes' => 'nullable|string',
            'recorded_at' => 'nullable|date',
        ]);

        $vitalSign->update($validated);

        return redirect()->route('vital-signs.show', $vitalSign)
            ->with('success', 'Vital signs updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VitalSign $vitalSign)
    {
        $vitalSign->delete();

        return redirect()->route('vital-signs.index')
            ->with('success', 'Vital signs record deleted successfully.');
    }
}
