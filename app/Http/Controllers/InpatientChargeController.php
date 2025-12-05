<?php

namespace App\Http\Controllers;

use App\Models\InpatientAdmission;
use App\Models\InpatientCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InpatientChargeController extends Controller
{
    public function index(InpatientAdmission $inpatient)
    {
        $charges = $inpatient->biayaRawatInap()
            ->with('ditagihOleh')
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalCharges = $charges->sum('total');
        
        // Group by charge type for summary
        $chargesByType = $charges->groupBy('jenis_biaya')->map(function ($group) {
            return [
                'count' => $group->count(),
                'total' => $group->sum('total'),
            ];
        });

        return view('inpatient.charges.index', compact('inpatient', 'charges', 'totalCharges', 'chargesByType'));
    }

    public function create(InpatientAdmission $inpatient)
    {
        return view('inpatient.charges.create', compact('inpatient'));
    }

    public function store(Request $request, InpatientAdmission $inpatient)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis_biaya' => 'required|in:room,doctor_visit,medication,procedure,lab,radiology,nursing_care,consultation,other',
            'deskripsi' => 'required|string',
            'jumlah' => 'required|numeric|min:0',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        $validated['rawat_inap_id'] = $inpatient->id;
        $validated['ditagih_oleh'] = Auth::id();

        InpatientCharge::create($validated);

        return redirect()->route('inpatient.charges.index', $inpatient)
            ->with('success', 'Charge berhasil ditambahkan');
    }

    public function destroy(InpatientAdmission $inpatient, InpatientCharge $charge)
    {
        $charge->delete();

        return redirect()->route('inpatient.charges.index', $inpatient)
            ->with('success', 'Charge berhasil dihapus');
    }
}
