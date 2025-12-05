<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Medication::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode', 'like', "%{$search}%");
        }

        if ($request->filled('low_stock')) {
            $query->whereColumn('stok', '<=', 'stok_minimum');
        }

        $medications = $query->orderBy('nama')->paginate(20);

        return view('medications.index', compact('medications'));
    }

    public function create()
    {
        return view('medications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|unique:obat,kode',
            'deskripsi' => 'nullable|string',
            'satuan' => 'required|string|max:50',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
        ]);

        $medication = Medication::create($validated);

        return redirect()->route('medications.index')
            ->with('success', 'Obat berhasil ditambahkan');
    }

    public function show(Medication $medication)
    {
        return view('medications.show', compact('medication'));
    }

    public function edit(Medication $medication)
    {
        return view('medications.edit', compact('medication'));
    }

    public function update(Request $request, Medication $medication)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'satuan' => 'required|string|max:50',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
        ]);

        $medication->update($validated);

        return redirect()->route('medications.show', $medication)
            ->with('success', 'Data obat berhasil diperbarui');
    }

    public function destroy(Medication $medication)
    {
        $medication->delete();

        return redirect()->route('medications.index')
            ->with('success', 'Obat berhasil dihapus');
    }
}
