<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\LaboratoryOrder;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\RadiologyOrder;
use App\Models\ServiceCharge;
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
            'alasan' => $validated['keluhan'] ?? 'Konsultasi Umum', // Default if no complaint provided
            'catatan' => $validated['keluhan'], // Can be null
            'jenis' => 'rawat_jalan', // Default to rawat_jalan (valid enum)
            'status' => 'terjadwal',
            'nomor_antrian' => ($lastQueue ?? 0) + 1,
        ]);

        // Create Invoice for the appointment
        $invoice = Invoice::create([
            'nomor_tagihan' => 'INV-' . date('Ymd') . '-' . str_pad(Invoice::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT),
            'pasien_id' => $patient->id,
            'janji_temu_id' => $appointment->id,
            'tagihan_untuk_id' => $appointment->id,
            'tagihan_untuk_tipe' => 'App\\Models\\Appointment',
            'status' => 'belum_dibayar',
            'subtotal' => 0,
            'diskon' => 0,
            'pajak' => 0,
            'total' => 0,
        ]);

        // Add consultation fee to invoice
        $doctor = Doctor::find($validated['dokter_id']);
        $feeAmount = ServiceCharge::where('nama_layanan', 'Konsultasi Dokter')
            ->where('kategori', 'konsultasi')
            ->value('harga') ?? 150000; // Default fee if not found

        InvoiceItem::create([
            'tagihan_id' => $invoice->id,
            'tipe' => 'service',
            'deskripsi' => 'Biaya Konsultasi - ' . $doctor->user->nama,
            'jumlah' => 1,
            'harga_satuan' => $feeAmount,
            'total' => $feeAmount,
        ]);

        // Update invoice totals
        $invoice->subtotal = $feeAmount;
        $invoice->total = $feeAmount;
        $invoice->save();

        return redirect()->route('patient.appointments')
            ->with('success', 'Janji temu berhasil dibuat! Nomor antrian Anda: ' . $appointment->nomor_antrian . '. Biaya konsultasi: Rp ' . number_format($feeAmount, 0, ',', '.'));
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
                ->with(['itemTagihan', 'pembayaran'])
                ->latest()
                ->paginate(10);
        }

        return view('patient.invoices', compact('patient', 'invoices'));
    }

    /**
     * Process payment for invoice using Midtrans.
     */
    public function payInvoice(Invoice $invoice)
    {
        $patient = $this->getPatient();

        // Verify invoice belongs to patient
        if (!$patient || $invoice->pasien_id !== $patient->id) {
            return redirect()->route('patient.invoices')
                ->with('error', 'Tagihan tidak ditemukan.');
        }

        // Check if already paid
        if ($invoice->status === 'lunas') {
            return redirect()->route('patient.invoices')
                ->with('info', 'Tagihan sudah lunas.');
        }

        $midtransService = new \App\Services\MidtransService();
        $result = $midtransService->createSnapToken($invoice);

        if ($result['success']) {
            // Store order_id in session for callback verification
            session(['payment_order_id' => $result['order_id']]);
            session(['payment_invoice_id' => $invoice->id]);
            
            // Redirect to Midtrans payment page
            return redirect($result['redirect_url']);
        }

        return redirect()->route('patient.invoices')
            ->with('error', $result['message'] ?? 'Gagal membuat pembayaran.');
    }

    /**
     * Handle successful payment callback.
     */
    public function paymentSuccess(\Illuminate\Http\Request $request)
    {
        $orderId = $request->query('order_id');
        
        if ($orderId) {
            // Extract invoice ID from order_id (format: INV-{invoice_id}-{timestamp})
            preg_match('/INV-(\d+)-/', $orderId, $matches);
            
            if (isset($matches[1])) {
                $invoiceId = $matches[1];
                $invoice = Invoice::find($invoiceId);
                
                if ($invoice) {
                    // Check transaction status from Midtrans
                    $midtransService = new \App\Services\MidtransService();
                    $status = $midtransService->getTransactionStatus($orderId);
                    
                    if ($status['success'] && in_array($status['transaction_status'], ['capture', 'settlement'])) {
                        // Update invoice status
                        $invoice->status = 'lunas';
                        $invoice->save();
                        
                        // Check if payment record already exists
                        $existingPayment = \App\Models\Payment::where('nomor_referensi', $orderId)->first();
                        
                        if (!$existingPayment) {
                            // Map Midtrans payment type to our payment methods
                            $paymentType = $status['payment_type'] ?? 'online';
                            $metodePembayaran = match($paymentType) {
                                'bank_transfer', 'echannel', 'bca_klikpay', 'bca_klikbca', 'mandiri_clickpay', 'cimb_clicks', 'danamon_online', 'bri_epay' => 'transfer',
                                'credit_card' => 'kartu_kredit',
                                'debit_card' => 'kartu_debit',
                                'gopay', 'shopeepay', 'qris' => 'online',
                                default => 'online',
                            };
                            
                            // Create payment record
                            \App\Models\Payment::create([
                                'tagihan_id' => $invoice->id,
                                'jumlah' => $invoice->total,
                                'metode_pembayaran' => $metodePembayaran,
                                'nomor_referensi' => $orderId,
                                'tanggal_pembayaran' => now(),
                                'diterima_oleh' => auth()->id(), // Patient who made the payment
                            ]);
                        }
                    }
                }
            }
        }
        
        return view('patient.payment-success');
    }

    /**
     * Handle pending payment callback.
     */
    public function paymentPending()
    {
        return view('patient.payment-pending');
    }

    /**
     * Handle failed payment callback.
     */
    public function paymentFailed()
    {
        return view('patient.payment-failed');
    }

    /**
     * Handle Midtrans notification webhook.
     */
    public function midtransNotification(\Illuminate\Http\Request $request)
    {
        $midtransService = new \App\Services\MidtransService();
        
        // Get notification data
        $notif = $request->all();
        
        \Illuminate\Support\Facades\Log::info('Midtrans Notification Received', $notif);
        
        // Verify signature
        $serverKey = config('midtrans.server_key');
        $hashed = hash('sha512', $notif['order_id'] . $notif['status_code'] . $notif['gross_amount'] . $serverKey);
        
        if ($hashed !== $notif['signature_key']) {
            \Illuminate\Support\Facades\Log::error('Invalid Midtrans Signature', [
                'expected' => $hashed,
                'received' => $notif['signature_key']
            ]);
            return response()->json(['status' => 'error', 'message' => 'Invalid signature'], 403);
        }
        
        // Extract invoice ID from order_id (format: INV-{invoice_id}-{timestamp})
        $orderId = $notif['order_id'];
        preg_match('/INV-(\d+)-/', $orderId, $matches);
        
        if (!isset($matches[1])) {
            \Illuminate\Support\Facades\Log::error('Invalid Order ID Format', ['order_id' => $orderId]);
            return response()->json(['status' => 'error', 'message' => 'Invalid order ID'], 400);
        }
        
        $invoiceId = $matches[1];
        $invoice = Invoice::find($invoiceId);
        
        if (!$invoice) {
            \Illuminate\Support\Facades\Log::error('Invoice Not Found', ['invoice_id' => $invoiceId]);
            return response()->json(['status' => 'error', 'message' => 'Invoice not found'], 404);
        }
        
        $transactionStatus = $notif['transaction_status'];
        $fraudStatus = $notif['fraud_status'] ?? 'accept';
        
        // Update invoice status based on transaction status
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            if ($fraudStatus == 'accept') {
                // Payment successful
                $invoice->status = 'lunas';
                $invoice->save();
                
                // Map Midtrans payment type to our payment methods
                $paymentType = $notif['payment_type'] ?? 'online';
                $metodePembayaran = match($paymentType) {
                    'bank_transfer', 'echannel', 'bca_klikpay', 'bca_klikbca', 'mandiri_clickpay', 'cimb_clicks', 'danamon_online', 'bri_epay' => 'transfer',
                    'credit_card' => 'kartu_kredit',
                    'debit_card' => 'kartu_debit',
                    'gopay', 'shopeepay', 'qris' => 'online',
                    default => 'online',
                };
                
                // Create payment record
                \App\Models\Payment::create([
                    'tagihan_id' => $invoice->id,
                    'jumlah' => $invoice->total,
                    'metode_pembayaran' => $metodePembayaran,
                    'nomor_referensi' => $orderId,
                    'tanggal_pembayaran' => now(),
                    'diterima_oleh' => 1, // System/Admin user for webhook payments
                ]);
                
                \Illuminate\Support\Facades\Log::info('Payment Successful', ['invoice_id' => $invoiceId, 'order_id' => $orderId]);
            }
        } elseif ($transactionStatus == 'pending') {
            // Payment pending
            $invoice->status = 'belum_dibayar';
            $invoice->save();
            
            \Illuminate\Support\Facades\Log::info('Payment Pending', ['invoice_id' => $invoiceId, 'order_id' => $orderId]);
        } elseif ($transactionStatus == 'deny' || $transactionStatus == 'cancel' || $transactionStatus == 'expire') {
            // Payment failed/cancelled
            $invoice->status = 'dibatalkan';
            $invoice->save();
            
            \Illuminate\Support\Facades\Log::info('Payment Failed/Cancelled', ['invoice_id' => $invoiceId, 'order_id' => $orderId, 'status' => $transactionStatus]);
        }
        
        return response()->json(['status' => 'success']);
    }
}
