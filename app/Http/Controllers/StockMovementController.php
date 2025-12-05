<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function index(Request $request)
    {
        $query = StockMovement::with(['obat', 'user']);

        if ($request->filled('obat_id')) {
            $query->where('obat_id', $request->obat_id);
        }

        if ($request->filled('jenis_mutasi')) {
            $query->where('jenis_mutasi', $request->jenis_mutasi);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $movements = $query->latest()->paginate(50);
        $medications = Medication::orderBy('nama')->get();

        return view('stock-movements.index', compact('movements', 'medications'));
    }

    public function show(Medication $medication)
    {
        $movements = StockMovement::where('obat_id', $medication->id)
            ->with('user')
            ->latest()
            ->paginate(50);

        $summary = [
            'in' => StockMovement::where('obat_id', $medication->id)->where('jenis_mutasi', 'in')->sum('jumlah'),
            'out' => StockMovement::where('obat_id', $medication->id)->where('jenis_mutasi', 'out')->sum('jumlah'),
            'adjustment' => StockMovement::where('obat_id', $medication->id)->where('jenis_mutasi', 'adjustment')->sum('jumlah'),
            'expired' => StockMovement::where('obat_id', $medication->id)->where('jenis_mutasi', 'expired')->sum('jumlah'),
            'damaged' => StockMovement::where('obat_id', $medication->id)->where('jenis_mutasi', 'damaged')->sum('jumlah'),
        ];

        return view('stock-movements.show', compact('medication', 'movements', 'summary'));
    }

    public function create()
    {
        $medications = Medication::orderBy('nama')->get();

        return view('stock-movements.create', compact('medications'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'obat_id' => 'required|exists:obat,id',
            'jenis_mutasi' => 'required|in:in,adjustment,expired,damaged',
            'jumlah' => 'required|numeric|min:0.01',
            'keterangan' => 'nullable|string',
        ]);

        $medication = Medication::findOrFail($validated['obat_id']);

        StockMovement::recordMovement(
            $medication,
            $validated['jenis_mutasi'],
            $validated['jumlah'],
            null,
            null,
            $validated['keterangan'] ?? null
        );

        return redirect()->route('stock-movements.index')
            ->with('success', 'Stock movement berhasil dicatat');
    }
}
