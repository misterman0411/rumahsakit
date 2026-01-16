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
use App\Models\Department;
use App\Models\InpatientAdmission;
use App\Models\Room;
use App\Models\Bed;
use App\Models\User;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ManagementReportController extends Controller
{
    /**
     * Executive Summary - Overview of all metrics
     */
    public function index()
    {
        $today = today();
        $thisMonth = now()->month;
        $thisYear = now()->year;

        $stats = [
            // Quick Financial
            'today_revenue' => Payment::whereDate('tanggal_pembayaran', $today)->sum('jumlah'),
            'month_revenue' => Payment::whereMonth('tanggal_pembayaran', $thisMonth)->whereYear('tanggal_pembayaran', $thisYear)->sum('jumlah'),
            'unpaid_total' => Invoice::where('status', 'belum_dibayar')->sum('total'),
            
            // Quick Operational
            'today_appointments' => Appointment::whereDate('tanggal_janji', $today)->count(),
            'lab_pending' => LaboratoryOrder::where('status', 'menunggu')->count(),
            'rad_pending' => RadiologyOrder::where('status', 'menunggu')->count(),
            'rx_pending' => Prescription::where('status', 'menunggu')->count(),
            
            // Patient
            'total_patients' => Patient::count(),
            'new_patients_today' => Patient::whereDate('created_at', $today)->count(),
            'active_inpatients' => InpatientAdmission::where('status', 'aktif')->count(),
            
            // Staff
            'total_doctors' => Doctor::count(),
            'total_nurses' => Nurse::count(),
            
            // Pharmacy Inventory
            'low_stock_items' => Medication::whereColumn('stok', '<=', 'stok_minimum')->count(),
            'expiring_soon' => Medication::whereNotNull('tanggal_kadaluarsa')
                ->where('tanggal_kadaluarsa', '<=', now()->addMonths(3))
                ->where('tanggal_kadaluarsa', '>', now())
                ->count(),
            'total_inventory_value' => Medication::selectRaw('SUM(stok * harga) as total')->value('total') ?? 0,
        ];

        return view('management.index', compact('stats'));
    }

    /**
     * Financial Report
     */
    public function financial(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);
        $endDate = now();

        // Revenue by period
        $payments = Payment::whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->selectRaw('DATE(tanggal_pembayaran) as date, SUM(jumlah) as total, metode_pembayaran')
            ->groupBy('date', 'metode_pembayaran')
            ->orderBy('date')
            ->get();

        // Daily revenue for chart
        $dailyRevenue = Payment::whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->selectRaw('DATE(tanggal_pembayaran) as date, SUM(jumlah) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Outstanding invoices
        $outstandingInvoices = Invoice::where('status', 'belum_dibayar')
            ->with(['pasien'])
            ->orderBy('jatuh_tempo')
            ->get();

        // Revenue by payment method
        $revenueByMethod = Payment::whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->selectRaw('metode_pembayaran, SUM(jumlah) as total, COUNT(*) as count')
            ->groupBy('metode_pembayaran')
            ->get();

        // Recent Payments (Detailed List)
        $recentPayments = Payment::with(['tagihan.pasien', 'diterimaOleh'])
            ->whereBetween('tanggal_pembayaran', [$startDate, $endDate])
            ->orderBy('tanggal_pembayaran', 'desc')
            ->limit(50)
            ->get();

        // Summary stats
        $stats = [
            'total_revenue' => $payments->sum('total'),
            'total_outstanding' => $outstandingInvoices->sum('total'),
            'overdue_count' => $outstandingInvoices->where('jatuh_tempo', '<', now())->count(),
            'paid_invoices' => Invoice::whereBetween('updated_at', [$startDate, $endDate])->where('status', 'lunas')->count(),
        ];

        return view('management.financial', compact('stats', 'dailyRevenue', 'outstandingInvoices', 'revenueByMethod', 'period', 'recentPayments'));
    }

    /**
     * Operational Performance
     */
    public function operational(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);
        $endDate = now();

        // Laboratory stats
        $labStats = [
            'total' => LaboratoryOrder::whereBetween('created_at', [$startDate, $endDate])->count(),
            'completed' => LaboratoryOrder::whereBetween('created_at', [$startDate, $endDate])->where('status', 'selesai')->count(),
            'pending' => LaboratoryOrder::where('status', 'menunggu')->count(),
            'in_progress' => LaboratoryOrder::whereIn('status', ['sampel_diambil', 'sedang_diproses'])->count(),
        ];
        $labStats['completion_rate'] = $labStats['total'] > 0 ? round($labStats['completed'] / $labStats['total'] * 100) : 0;

        // Radiology stats
        $radStats = [
            'total' => RadiologyOrder::whereBetween('created_at', [$startDate, $endDate])->count(),
            'completed' => RadiologyOrder::whereBetween('created_at', [$startDate, $endDate])->where('status', 'selesai')->count(),
            'pending' => RadiologyOrder::where('status', 'menunggu')->count(),
            'draft' => RadiologyOrder::where('report_status', 'draft')->count(),
        ];
        $radStats['completion_rate'] = $radStats['total'] > 0 ? round($radStats['completed'] / $radStats['total'] * 100) : 0;

        // Pharmacy stats
        $rxStats = [
            'total' => Prescription::whereBetween('created_at', [$startDate, $endDate])->count(),
            'completed' => Prescription::whereBetween('created_at', [$startDate, $endDate])->where('status', 'selesai')->count(),
            'pending' => Prescription::where('status', 'menunggu')->count(),
            'verified' => Prescription::where('status', 'diverifikasi')->count(),
        ];
        $rxStats['completion_rate'] = $rxStats['total'] > 0 ? round($rxStats['completed'] / $rxStats['total'] * 100) : 0;

        // Pharmacy Inventory Details
        $lowStockMedications = Medication::whereColumn('stok', '<=', 'stok_minimum')
            ->orderBy('stok', 'asc')
            ->limit(10)
            ->get();

        $expiringMedications = Medication::whereNotNull('tanggal_kadaluarsa')
            ->where('tanggal_kadaluarsa', '<=', now()->addMonths(3))
            ->where('tanggal_kadaluarsa', '>', now())
            ->orderBy('tanggal_kadaluarsa', 'asc')
            ->limit(10)
            ->get();

        $topMedications = DB::table('item_resep')
            ->join('obat', 'item_resep.obat_id', '=', 'obat.id')
            ->join('resep', 'item_resep.resep_id', '=', 'resep.id')
            ->whereBetween('resep.created_at', [$startDate, $endDate])
            ->select('obat.nama', 'obat.kode', DB::raw('COUNT(*) as prescription_count'))
            ->groupBy('obat.id', 'obat.nama', 'obat.kode')
            ->orderBy('prescription_count', 'desc')
            ->limit(10)
            ->get();

        $inventoryStats = [
            'total_items' => Medication::count(),
            'low_stock_count' => Medication::whereColumn('stok', '<=', 'stok_minimum')->count(),
            'expiring_soon_count' => Medication::whereNotNull('tanggal_kadaluarsa')
                ->where('tanggal_kadaluarsa', '<=', now()->addMonths(3))
                ->where('tanggal_kadaluarsa', '>', now())
                ->count(),
            'total_value' => Medication::selectRaw('SUM(stok * harga) as total')->value('total') ?? 0,
        ];

        // Clinic/Appointment stats by department
        $clinicStats = Department::withCount([
            'janjiTemu as total_appointments' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal_janji', [$startDate, $endDate]);
            },
            'janjiTemu as completed_appointments' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('tanggal_janji', [$startDate, $endDate])->where('status', 'selesai');
            },
        ])->get();

        // Recent Stock Movements (for Operational Report)
        $recentStockMovements = \App\Models\StockMovement::with(['obat', 'user'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return view('management.operational', compact(
            'labStats', 'radStats', 'rxStats', 'clinicStats', 'period',
            'lowStockMedications', 'expiringMedications', 'topMedications', 'inventoryStats',
            'recentStockMovements'
        ));
    }

    /**
     * Patient Flow Report
     */
    public function patientFlow(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);
        $endDate = now();

        // Total patients
        $totalPatients = Patient::count();

        // New patients in period
        $newPatients = Patient::whereBetween('created_at', [$startDate, $endDate])->count();

        // Total appointments in period
        $totalAppointments = Appointment::whereBetween('tanggal_janji', [$startDate, $endDate])->count();

        // Current inpatients
        $currentInpatients = InpatientAdmission::where('status', 'aktif')->count();

        // Appointments by status
        $appointmentsByStatus = Appointment::whereBetween('tanggal_janji', [$startDate, $endDate])
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Inpatient statistics
        $inpatientStats = [
            'new_admissions' => InpatientAdmission::whereBetween('tanggal_masuk', [$startDate, $endDate])->count(),
            'discharged' => InpatientAdmission::whereBetween('tanggal_keluar', [$startDate, $endDate])->count(),
            'current' => $currentInpatients,
            'avg_stay' => InpatientAdmission::whereNotNull('tanggal_keluar')
                ->whereBetween('tanggal_keluar', [$startDate, $endDate])
                ->selectRaw('AVG(DATEDIFF(tanggal_keluar, tanggal_masuk)) as avg_days')
                ->value('avg_days') ?? 0,
        ];

        // Daily visits
        $dailyVisits = Appointment::whereBetween('tanggal_janji', [$startDate, $endDate])
            ->selectRaw('DATE(tanggal_janji) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Room occupancy
        $roomOccupancy = Room::select('ruangan.id', 'ruangan.nomor_ruangan', 'departemen.nama as departemen')
            ->leftJoin('departemen', 'ruangan.departemen_id', '=', 'departemen.id')
            ->withCount(['tempatTidur as total_beds'])
            ->withCount(['tempatTidur as occupied_beds' => function ($q) {
                $q->where('status', 'terisi');
            }])
            ->having('total_beds', '>', 0)
            ->get();

        // Recent patient visits (Detailed Table)
        $recentVisits = Appointment::with(['pasien', 'dokter.user', 'departemen'])
            ->whereBetween('tanggal_janji', [$startDate, $endDate])
            ->orderBy('tanggal_janji', 'desc')
            ->limit(50)
            ->get();

        return view('management.patient-flow', compact(
            'totalPatients', 'newPatients', 'totalAppointments', 'currentInpatients',
            'appointmentsByStatus', 'inpatientStats', 'dailyVisits', 'roomOccupancy', 'period',
            'recentVisits'
        ));
    }

    /**
     * Staff Performance Report
     */
    public function staffPerformance(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $this->getStartDate($period);
        $endDate = now();

        // Doctor performance
        $doctorPerformance = Doctor::with(['user', 'departemen'])
            ->withCount([
                'janjiTemu as total_appointments' => function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('tanggal_janji', [$startDate, $endDate]);
                },
                'janjiTemu as completed_appointments' => function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('tanggal_janji', [$startDate, $endDate])->where('status', 'selesai');
                },
            ])
            ->get()
            ->map(function ($doctor) {
                return (object) [
                    'id' => $doctor->id,
                    'nama' => $doctor->user?->nama ?? 'Unknown',
                    'departemen' => $doctor->departemen?->nama ?? '-',
                    'total_appointments' => $doctor->total_appointments,
                    'completed_appointments' => $doctor->completed_appointments,
                ];
            });

        // Lab technician performance
        $labTechPerformance = User::select('users.id', 'users.nama')
            ->join('peran', 'users.peran_id', '=', 'peran.id')
            ->where('peran.nama', 'lab_technician')
            ->withCount(['laboratoryResultsEntered as total_tests' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('waktu_input_hasil', [$startDate, $endDate]);
            }])
            ->get();

        // Radiologist performance
        $radiologistPerformance = User::select('users.id', 'users.nama')
            ->join('peran', 'users.peran_id', '=', 'peran.id')
            ->where('peran.nama', 'radiologist')
            ->withCount(['radiologySignedReports as total_exams' => function ($q) use ($startDate, $endDate) {
                $q->whereBetween('signed_at', [$startDate, $endDate]);
            }])
            ->get();

        // Detailed Staff Logs (Recent Activities)
        $recentStaffActivities = Appointment::with(['dokter.user', 'pasien', 'departemen'])
            ->whereBetween('tanggal_janji', [$startDate, $endDate])
            ->whereIn('status', ['selesai', 'sedang_diperiksa'])
            ->orderBy('updated_at', 'desc')
            ->limit(50)
            ->get();

        return view('management.staff-performance', compact('doctorPerformance', 'labTechPerformance', 'radiologistPerformance', 'period', 'recentStaffActivities'));
    }

    /**
     * Helper: Get start date based on period
     */
    private function getStartDate($period)
    {
        return match($period) {
            'today' => today(),
            'week' => now()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'quarter' => now()->startOfQuarter(),
            'year' => now()->startOfYear(),
            default => now()->startOfMonth(),
        };
    }
}
