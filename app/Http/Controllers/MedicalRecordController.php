<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['pasien', 'dokter.user', 'janjiTemu']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pasien', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_rekam_medis', 'like', "%{$search}%");
            });
        }

        $records = $query->latest()->paginate(20);

        return view('medical-records.index', compact('records'));
    }

    public function create()
    {
        $patients = Patient::orderBy('nama')->get();
        $doctors = Doctor::with('user')->get();
        $appointments = Appointment::where('status', 'check_in')
            ->whereNotNull('tanggal_janji')
            ->with(['pasien', 'dokter.user'])
            ->get();
        
        return view('medical-records.create', compact('patients', 'doctors', 'appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'dokter_id' => 'required|exists:dokter,id',
            'janji_temu_id' => 'nullable|exists:janji_temu,id',
            'keluhan' => 'required|string',
            'tanda_vital' => 'nullable|array',
            'diagnosis' => 'required|string',
            'kode_icd10' => 'nullable|string|max:10',
            'kode_icd9' => 'nullable|string|max:10',
            'rencana_perawatan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $record = MedicalRecord::create($validated);

        // Update appointment status to completed
        if ($validated['janji_temu_id'] ?? null) {
            Appointment::find($validated['janji_temu_id'])->update(['status' => 'selesai']);
        }

        return redirect()->route('medical-records.show', $record)
            ->with('success', 'Rekam medis berhasil disimpan');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['pasien', 'dokter.user', 'janjiTemu']);

        return view('medical-records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        return view('medical-records.edit', compact('medicalRecord'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'keluhan_utama' => 'nullable|string',
            'keluhan' => 'required|string',
            'tanda_vital' => 'nullable|array',
            'pemeriksaan_fisik' => 'nullable|string',
            'diagnosis' => 'required|string',
            'kode_icd10_utama' => 'nullable|string|max:10',
            'kode_icd10_sekunder' => 'nullable|array',
            'kode_icd10_sekunder.*' => 'nullable|string|max:10',
            'rencana_perawatan' => 'nullable|string',
            'kode_icd9_prosedur' => 'nullable|array',
            'kode_icd9_prosedur.*' => 'nullable|string|max:10',
            'catatan' => 'nullable|string',
            'rekomendasi' => 'nullable|string',
        ]);

        $medicalRecord->update($validated);

        return redirect()->route('medical-records.show', $medicalRecord)
            ->with('success', 'Rekam medis berhasil diperbarui');
    }
}
