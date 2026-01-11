<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Prescription;
use App\Models\LaboratoryOrder;
use App\Models\RadiologyOrder;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $role = $user->peran->nama ?? 'guest';

        if ($role === 'management') {
            return redirect()->route('management.index');
        }

        if ($role === 'patient') {
            return redirect()->route('patient.dashboard');
        }

        if ($role === 'guest') {
            return redirect()->route('home');
        }

        $stats = [];
        $appointments = [];
        $recent_patients = [];

        switch ($role) {
            case 'admin':
                $stats = [
                    'total_patients' => Patient::count(),
                    'total_doctors' => Doctor::count(),
                    'total_nurses' => Nurse::count(),
                    'today_appointments' => Appointment::whereDate('tanggal_janji', today())->count(),
                ];
                $appointments = Appointment::with(['pasien', 'dokter.user'])
                    ->whereDate('tanggal_janji', today())
                    ->latest('tanggal_janji')
                    ->limit(10)
                    ->get();
                break;

            case 'doctor':
                $doctor = Doctor::where('user_id', $user->id)->first();
                if ($doctor) {
                    $stats = [
                        'today_appointments' => Appointment::where('dokter_id', $doctor->id)
                            ->whereDate('tanggal_janji', today())
                            ->count(),
                        'pending_records' => Appointment::where('dokter_id', $doctor->id)
                            ->where('status', 'check_in')
                            ->count(),
                    ];
                    $appointments = Appointment::with(['pasien', 'departemen'])
                        ->where('dokter_id', $doctor->id)
                        ->whereDate('tanggal_janji', today())
                        ->latest('tanggal_janji')
                        ->get();
                }
                break;

            case 'nurse':
                $stats = [
                    'today_appointments' => Appointment::whereDate('tanggal_janji', today())->count(),
                    'checked_in' => Appointment::where('status', 'check_in')->count(),
                ];
                break;

            case 'front_office':
                $stats = [
                    'today_appointments' => Appointment::whereDate('tanggal_janji', today())->count(),
                    'pending_checkin' => Appointment::where('status', 'terjadwal')
                        ->whereDate('tanggal_janji', today())
                        ->count(),
                ];
                $appointments = Appointment::with(['pasien', 'dokter.user'])
                    ->whereDate('tanggal_janji', today())
                    ->latest('tanggal_janji')
                    ->limit(10)
                    ->get();
                $recent_patients = Patient::latest()->limit(10)->get();
                break;

            case 'pharmacist':
                $stats = [
                    'pending_prescriptions' => Prescription::where('status', 'menunggu')->count(),
                    'verified_prescriptions' => Prescription::where('status', 'diverifikasi')->count(),
                ];
                break;

            case 'cashier':
                $stats = [
                    'unpaid_invoices' => Invoice::where('status', 'belum_dibayar')->count(),
                    'today_revenue' => Payment::whereDate('tanggal_pembayaran', today())->sum('jumlah'),
                ];
                break;

            case 'lab_technician':
                $stats = [
                    'pending_tests' => LaboratoryOrder::where('status', 'menunggu')->count(),
                    'in_progress' => LaboratoryOrder::whereIn('status', ['sampel_diambil', 'sedang_diproses'])->count(),
                ];
                break;

            case 'radiologist':
                $stats = [
                    'pending_exams' => RadiologyOrder::where('status', 'menunggu')->count(),
                    'in_progress' => RadiologyOrder::where('status', 'sedang_diproses')->count(),
                ];
                break;

            // Management role redirected to Management Dashboard
        }

        return view('dashboard', compact('role', 'stats', 'appointments', 'recent_patients'));
    }
}
