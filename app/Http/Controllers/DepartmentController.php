<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount(['dokter'])->paginate(20);
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|unique:departemen,kode',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'kepala_departemen' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ]);

        $department = Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Departemen berhasil ditambahkan');
    }

    public function show(Department $department)
    {
        $department->load(['dokter.user']);
        return view('departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'lokasi' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'kepala_departemen' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ]);

        $department->update($validated);

        return redirect()->route('departments.show', $department)
            ->with('success', 'Departemen berhasil diperbarui');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Departemen berhasil dihapus');
    }
}
