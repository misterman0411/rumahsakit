<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Invoice;
use App\Models\LaboratoryOrder;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\RadiologyOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientPortalController extends Controller
{
    /**
     * Get the patient record for the current user.
     */
    protected function getPatient()
    {
        return Patient::where('user_id', Auth::id())->first();
    }

    /**
     * Display the patient dashboard.
     */
    public function dashboard()
    {
        $patient = $this->getPatient();
        
        $upcomingAppointments = collect();
        $recentMedicalRecords = collect();
        $activePrescriptions = collect();
        $pendingInvoices = collect();
        $stats = [
            'total_visits' => 0,
            'total_prescriptions' => 0,
            'pending_invoices' => 0,
            'upcoming_appointments' => 0,
        ];

        if ($patient) {
            $upcomingAppointments = Appointment::where('pasien_id', $patient->id)
                ->whereDate('tanggal_janji', '>=', today())
                ->whereIn('status', ['terjadwal', 'dikonfirmasi'])
                ->with(['dokter.user', 'departemen'])
                ->orderBy('tanggal_janji')
                ->limit(5)
                ->get();

            $recentMedicalRecords = MedicalRecord::where('pasien_id', $patient->id)
                ->with(['dokter.user'])
                ->latest()
                ->limit(3)
                ->get();

            $activePrescriptions = Prescription::where('pasien_id', $patient->id)
                ->whereIn('status', ['pending', 'verified'])
                ->with(['dokter.user'])
                ->latest()
                ->limit(3)
                ->get();

            $pendingInvoices = Invoice::where('pasien_id', $patient->id)
                ->where('status', 'unpaid')
                ->latest()
                ->limit(5)
                ->get();

            $stats = [
                'total_visits' => Appointment::where('pasien_id', $patient->id)
                    ->where('status', 'selesai')
                    ->count(),
                'total_prescriptions' => Prescription::where('pasien_id', $patient->id)->count(),
                'pending_invoices' => Invoice::where('pasien_id', $patient->id)
                    ->where('status', 'unpaid')
                    ->count(),
                'upcoming_appointments' => $upcomingAppointments->count(),
            ];
        }

        return view('patient.dashboard', compact(
            'patient',
            'upcomingAppointments',
            'recentMedicalRecords',
            'activePrescriptions',
            'pendingInvoices',
            'stats'
        ));
    }

    /**
     * Display patient's appointments.
     */
    public function appointments()
    {
        $patient = $this->getPatient();
        $appointments = collect();

        if ($patient) {
            $appointments = Appointment::where('pasien_id', $patient->id)
                ->with(['dokter.user', 'departemen'])
                ->latest('tanggal_janji')
                ->paginate(10);
        }

        return view('patient.appointments', compact('patient', 'appointments'));
    }

    /**
     * Display appointment booking form.
     */
    public function bookAppointment()
    {
        $patient = $this->getPatient();
        $departments = Department::orderBy('nama')->get();
        $doctors = Doctor::with(['user', 'departemen'])->get();

        return view('patient.book-appointment', compact('patient', 'departments', 'doctors'));
    }

    /**
     * Store a new appointment.
     */
    public function storeAppointment(Request $request)
    {
        $patient = $this->getPatient();

        if (!$patient) {
            return redirect()->route('patient.dashboard')
                ->with('error', 'Anda belum terdaftar sebagai pasien. Silakan hubungi bagian pendaftaran.');
        }

        $validated = $request->validate([
            'dokter_id' => 'required|exists:dokter,id',
            'departemen_id' => 'required|exists:departemen,id',
            'tanggal_janji' => 'required|date|after_or_equal:today',
            'waktu_janji' => 'required',
            'keluhan' => 'nullable|string|max:1000',
        ]);

        // Get the latest queue number for today
        $lastQueue = Appointment::whereDate('tanggal_janji', $validated['tanggal_janji'])
            ->where('departemen_id', $validated['departemen_id'])
            ->max('nomor_antrian');

        $appointment = Appointment::create([
            'pasien_id' => $patient->id,
            'dokter_id' => $validated['dokter_id'],
            'departemen_id' => $validated['departemen_id'],
            'tanggal_janji' => $validated['tanggal_janji'] . ' ' . $validated['waktu_janji'],
            'alasan' => $validated['keluhan'], // Map keluhan to alasan
            'catatan' => $validated['keluhan'], // Also map to catatan for redundancy if needed, or remove
            'jenis' => 'rawat_jalan', // Default to rawat_jalan (valid enum)
            'status' => 'terjadwal',
            'nomor_antrian' => ($lastQueue ?? 0) + 1,
        ]);

        return redirect()->route('patient.appointments')
            ->with('success', 'Janji temu berhasil dibuat! Nomor antrian Anda: ' . $appointment->nomor_antrian);
    }

    /**
     * Display patient's medical records.
     */
    public function medicalRecords()
    {
        $patient = $this->getPatient();
        $medicalRecords = collect();

        if ($patient) {
            $medicalRecords = MedicalRecord::where('pasien_id', $patient->id)
                ->with(['dokter.user'])
                ->latest()
                ->paginate(10);
        }

        return view('patient.medical-records', compact('patient', 'medicalRecords'));
    }

    /**
     * Display patient's prescriptions.
     */
    public function prescriptions()
    {
        $patient = $this->getPatient();
        $prescriptions = collect();

        if ($patient) {
            $prescriptions = Prescription::where('pasien_id', $patient->id)
                ->with(['dokter.user', 'items.obat'])
                ->latest()
                ->paginate(10);
        }

        return view('patient.prescriptions', compact('patient', 'prescriptions'));
    }

    /**
     * Display patient's laboratory results.
     */
    public function labResults()
    {
        $patient = $this->getPatient();
        $labResults = collect();

        if ($patient) {
            $labResults = LaboratoryOrder::where('pasien_id', $patient->id)
                ->with(['dokter.user', 'jenisTes', 'results'])
                ->latest()
                ->paginate(10);
        }

        return view('patient.lab-results', compact('patient', 'labResults'));
    }

    /**
     * Display patient's radiology results.
     */
    public function radiologyResults()
    {
        $patient = $this->getPatient();
        $radiologyResults = collect();

        if ($patient) {
            $radiologyResults = RadiologyOrder::where('pasien_id', $patient->id)
                ->with(['dokter.user', 'jenisTes'])
                ->latest()
                ->paginate(10);
        }

        return view('patient.radiology-results', compact('patient', 'radiologyResults'));
    }

    /**
     * Display patient's invoices.
     */
    public function invoices()
    {
        $patient = $this->getPatient();
        $invoices = collect();

        if ($patient) {
            $invoices = Invoice::where('pasien_id', $patient->id)
                ->with(['items', 'payments'])
                ->latest()
                ->paginate(10);
        }

        return view('patient.invoices', compact('patient', 'invoices'));
    }
}
