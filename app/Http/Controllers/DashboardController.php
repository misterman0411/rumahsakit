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
                    'pending_prescriptions' => Prescription::where('status', 'pending')->count(),
                    'verified_prescriptions' => Prescription::where('status', 'verified')->count(),
                ];
                break;

            case 'cashier':
                $stats = [
                    'unpaid_invoices' => Invoice::where('status', 'unpaid')->count(),
                    'today_revenue' => Payment::whereDate('tanggal_pembayaran', today())->sum('jumlah'),
                ];
                break;

            case 'lab_technician':
                $stats = [
                    'pending_tests' => LaboratoryOrder::where('status', 'ordered')->count(),
                    'in_progress' => LaboratoryOrder::where('status', 'in_progress')->count(),
                ];
                break;

            case 'radiologist':
                $stats = [
                    'pending_exams' => RadiologyOrder::where('status', 'ordered')->count(),
                    'scheduled' => RadiologyOrder::where('status', 'scheduled')->count(),
                ];
                break;
        }

        return view('dashboard', compact('role', 'stats', 'appointments', 'recent_patients'));
    }
}
