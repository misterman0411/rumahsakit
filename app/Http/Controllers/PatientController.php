<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_rekam_medis', 'like', "%{$search}%")
                  ->orWhere('telepon', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->paginate(20);

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'nullable|string|size:16|unique:pasien,nik',
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:laki_laki,perempuan',
            'agama' => 'nullable|in:islam,kristen,katolik,hindu,buddha,konghucu,other',
            'status_pernikahan' => 'nullable|in:belum_menikah,menikah,cerai,janda_duda',
            'kewarganegaraan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'required|string',
            'golongan_darah' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'alergi' => 'nullable|string',
            'nama_kontak_darurat' => 'required|string|max:255',
            'telepon_kontak_darurat' => 'required|string|max:20',
            'jenis_asuransi' => 'nullable|in:tidak_ada,bpjs,asuransi_swasta',
            'nomor_asuransi' => 'nullable|string|max:100',
            'status' => 'nullable|in:aktif,tidak_aktif,meninggal',
        ]);

        // Generate MRN
        $lastPatient = Patient::latest('id')->first();
        $nextNumber = $lastPatient ? ($lastPatient->id + 1) : 1;
        $validated['no_rekam_medis'] = 'MR-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT) . '-' . date('Y');
        $validated['status'] = $validated['status'] ?? 'aktif';
        $validated['jenis_asuransi'] = $validated['jenis_asuransi'] ?? 'tidak_ada';

        $patient = Patient::create($validated);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Pasien berhasil didaftarkan dengan MRN: ' . $patient->no_rekam_medis);
    }

    public function show(Patient $patient)
    {
        $patient->load([
            'janjiTemu.dokter.user',
            'rekamMedis.dokter.user',
            'resep.itemResep.obat',
            'permintaanLaboratorium.jenisTes',
            'permintaanRadiologi.jenisTes',
        ]);

        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'nik' => 'nullable|string|size:16|unique:pasien,nik,' . $patient->id,
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:laki_laki,perempuan',
            'agama' => 'nullable|in:islam,kristen,katolik,hindu,buddha,konghucu,other',
            'status_pernikahan' => 'nullable|in:belum_menikah,menikah,cerai,janda_duda',
            'kewarganegaraan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
            'telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'required|string',
            'golongan_darah' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'alergi' => 'nullable|string',
            'nama_kontak_darurat' => 'required|string|max:255',
            'telepon_kontak_darurat' => 'required|string|max:20',
            'jenis_asuransi' => 'nullable|in:tidak_ada,bpjs,asuransi_swasta',
            'nomor_asuransi' => 'nullable|string|max:100',
            'status' => 'nullable|in:aktif,tidak_aktif,meninggal',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Data pasien berhasil diperbarui');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Data pasien berhasil dihapus');
    }
}
