<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Bed;
use App\Models\Department;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = Room::withCount('tempatTidur');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $rooms = $query->orderBy('nomor_ruangan')->paginate(20);

        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        $departments = Department::orderBy('nama')->get();
        return view('rooms.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_ruangan' => 'required|string|unique:ruangan,nomor_ruangan',
            'jenis' => 'required|in:vip,kelas_1,kelas_2,kelas_3,icu,isolasi',
            'kapasitas' => 'required|integer|min:1',
            'tarif_per_hari' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,terisi,maintenance',
            'departemen_id' => 'required|exists:departemen,id',
        ]);

        $room = Room::create($validated);

        // Create beds for the room
        for ($i = 1; $i <= $validated['kapasitas']; $i++) {
            Bed::create([
                'ruangan_id' => $room->id,
                'nomor_tempat_tidur' => $validated['nomor_ruangan'] . '-' . $i,
                'status' => 'tersedia',
            ]);
        }

        return redirect()->route('rooms.index')
            ->with('success', 'Ruangan berhasil ditambahkan dengan ' . $validated['kapasitas'] . ' tempat tidur');
    }

    public function show(Room $room)
    {
        $room->load(['tempatTidur', 'rawatInap.pasien']);
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $departments = Department::orderBy('nama')->get();
        return view('rooms.edit', compact('room', 'departments'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|in:vip,kelas_1,kelas_2,kelas_3,icu,isolasi',
            'tarif_per_hari' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,terisi,maintenance',
            'departemen_id' => 'required|exists:departemen,id',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.show', $room)
            ->with('success', 'Data ruangan berhasil diperbarui');
    }

    public function destroy(Room $room)
    {
        $room->tempatTidur()->delete();
        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Ruangan berhasil dihapus');
    }
}
