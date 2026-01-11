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
        $query = VitalSign::with(['pasien', 'perawat']);

        // Filter by patient
        if ($request->filled('pasien_id')) {
            $query->where('pasien_id', $request->pasien_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('waktu_pengukuran', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('waktu_pengukuran', '<=', $request->date_to);
        }

        $vitalSigns = $query->latest('waktu_pengukuran')->paginate(15);
        $patients = Patient::orderBy('nama')->get();

        return view('vital-signs.index', compact('vitalSigns', 'patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::orderBy('nama')->get();

        return view('vital-signs.create', compact('patients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'rawat_inap_id' => 'nullable|exists:rawat_inap,id',
            'suhu' => 'nullable|numeric|between:30,45',
            'tekanan_darah_sistolik' => 'nullable|integer|between:50,250',
            'tekanan_darah_diastolik' => 'nullable|integer|between:30,150',
            'detak_jantung' => 'nullable|integer|between:30,250',
            'laju_pernapasan' => 'nullable|integer|between:5,60',
            'saturasi_oksigen' => 'nullable|numeric|between:50,100',
            'berat_badan' => 'nullable|numeric|between:0.5,500',
            'tinggi_badan' => 'nullable|numeric|between:20,300',
            'catatan' => 'nullable|string',
            'waktu_pengukuran' => 'nullable|date',
        ]);

        // Set perawat_id from authenticated user if they are a nurse
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if ($user && $user->hasRole('nurse')) {
            $nurse = \App\Models\Nurse::where('user_id', Auth::id())->first();
            if ($nurse) {
                $validated['perawat_id'] = $nurse->id;
            }
        }
        
        $validated['waktu_pengukuran'] = $validated['waktu_pengukuran'] ?? now();

        $vitalSign = VitalSign::create($validated);

        return redirect()->route('vital-signs.show', $vitalSign)
            ->with('success', 'Vital signs recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(VitalSign $vitalSign)
    {
        $vitalSign->load(['pasien', 'perawat.user', 'rawatInap']);

        return view('vital-signs.show', compact('vitalSign'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VitalSign $vitalSign)
    {
        $patients = Patient::orderBy('nama')->get();

        return view('vital-signs.edit', compact('vitalSign', 'patients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VitalSign $vitalSign)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasien,id',
            'rawat_inap_id' => 'nullable|exists:rawat_inap,id',
            'suhu' => 'nullable|numeric|between:30,45',
            'tekanan_darah_sistolik' => 'nullable|integer|between:50,250',
            'tekanan_darah_diastolik' => 'nullable|integer|between:30,150',
            'detak_jantung' => 'nullable|integer|between:30,250',
            'laju_pernapasan' => 'nullable|integer|between:5,60',
            'saturasi_oksigen' => 'nullable|numeric|between:50,100',
            'berat_badan' => 'nullable|numeric|between:0.5,500',
            'tinggi_badan' => 'nullable|numeric|between:20,300',
            'catatan' => 'nullable|string',
            'waktu_pengukuran' => 'nullable|date',
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
