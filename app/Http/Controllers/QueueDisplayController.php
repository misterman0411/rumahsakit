<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use Illuminate\Http\Request;
use Carbon\Carbon;

class QueueDisplayController extends Controller
{
    public function display($departmentId)
    {
        $department = Department::findOrFail($departmentId);
        $today = Carbon::today();

        // Get current queue (sedang_dilayani)
        $currentQueue = Appointment::with(['pasien', 'dokter.user'])
            ->where('departemen_id', $departmentId)
            ->whereDate('tanggal_janji', $today)
            ->where('status', 'sedang_dilayani')
            ->orderBy('waktu_mulai_konsultasi', 'desc')
            ->first();

        // Get waiting queue (check_in)
        $waitingQueue = Appointment::with(['pasien', 'dokter.user'])
            ->where('departemen_id', $departmentId)
            ->whereDate('tanggal_janji', $today)
            ->where('status', 'check_in')
            ->orderBy('nomor_antrian')
            ->take(10)
            ->get();

        // Statistics
        $totalToday = Appointment::where('departemen_id', $departmentId)
            ->whereDate('tanggal_janji', $today)
            ->whereIn('status', ['check_in', 'sedang_dilayani', 'selesai'])
            ->count();

        $completedToday = Appointment::where('departemen_id', $departmentId)
            ->whereDate('tanggal_janji', $today)
            ->where('status', 'selesai')
            ->count();

        return view('queue.display', compact(
            'department',
            'currentQueue',
            'waitingQueue',
            'totalToday',
            'completedToday'
        ));
    }

    public function printTicket($appointmentId)
    {
        $appointment = Appointment::with(['pasien', 'dokter.user', 'departemen'])
            ->findOrFail($appointmentId);

        // Ensure appointment is checked in
        if ($appointment->status !== 'check_in') {
            return redirect()->back()->with('error', 'Appointment must be checked in first.');
        }

        return view('queue.ticket', compact('appointment'));
    }
}
