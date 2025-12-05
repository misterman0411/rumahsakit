<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with(['user', 'departemen'])->paginate(20);
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        $departments = Department::orderBy('nama')->get();
        return view('doctors.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'departemen_id' => 'required|exists:departemen,id',
            'spesialisasi' => 'required|string|max:255',
            'nomor_izin_praktik' => 'required|string|unique:dokter,nomor_izin_praktik',
            'telepon' => 'required|string|max:20',
            'biaya_konsultasi' => 'required|numeric|min:0',
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'peran_id' => 2, // Doctor role
        ]);

        $doctor = Doctor::create([
            'user_id' => $user->id,
            'departemen_id' => $validated['departemen_id'],
            'spesialisasi' => $validated['spesialisasi'],
            'nomor_izin_praktik' => $validated['nomor_izin_praktik'],
            'telepon' => $validated['telepon'],
            'biaya_konsultasi' => $validated['biaya_konsultasi'],
        ]);

        return redirect()->route('doctors.index')
            ->with('success', 'Dokter berhasil didaftarkan');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'departemen', 'janjiTemu.pasien']);
        return view('doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        $departments = Department::orderBy('nama')->get();
        return view('doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'departemen_id' => 'required|exists:departemen,id',
            'spesialisasi' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'biaya_konsultasi' => 'required|numeric|min:0',
        ]);

        $doctor->update($validated);

        return redirect()->route('doctors.show', $doctor)
            ->with('success', 'Data dokter berhasil diperbarui');
    }
}
