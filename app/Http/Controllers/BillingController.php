<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['pasien', 'tagihanUntuk', 'itemTagihan', 'kunjungan']);

        // Filter berdasarkan role user (dokter hanya lihat tagihan pasiennya)
        $user = Auth::user();
        $role = $user->peran->nama ?? null;
        
        if ($role === 'doctor') {
            $doctor = \App\Models\Doctor::where('user_id', $user->id)->first();
            if ($doctor) {
                // Hanya tampilkan tagihan untuk pasien yang pernah ditangani dokter ini
                $pasienIds = \App\Models\Appointment::where('dokter_id', $doctor->id)
                    ->pluck('pasien_id')
                    ->unique();
                $query->whereIn('pasien_id', $pasienIds);
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('pasien_id')) {
            $query->where('pasien_id', $request->pasien_id);
        }

        // Search by invoice number or patient name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_tagihan', 'like', '%' . $search . '%')
                  ->orWhereHas('pasien', function($subq) use ($search) {
                      $subq->where('nama', 'like', '%' . $search . '%')
                           ->orWhere('no_rekam_medis', 'like', '%' . $search . '%');
                  });
            });
        }

        $invoices = $query->latest()->paginate(20);
        
        // Filter patients list for doctors
        if ($role === 'doctor' && isset($doctor)) {
            $patients = Patient::whereIn('id', $pasienIds)->orderBy('nama')->get();
        } else {
            $patients = Patient::orderBy('nama')->get();
        }

        return view('billing.index', compact('invoices', 'patients'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['pasien', 'tagihanUntuk', 'pembayaran', 'itemTagihan', 'kunjungan']);

        return view('billing.show', compact('invoice'));
    }

    public function payment(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:0|max:' . $invoice->total,
            'metode_pembayaran' => ['required', Rule::in(Payment::PAYMENT_METHODS)],
            'tanggal_pembayaran' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $payment = Payment::create([
                'tagihan_id' => $invoice->id,
                'jumlah' => $validated['jumlah'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
                'catatan' => $validated['catatan'] ?? null,
                'diterima_oleh' => Auth::id(),
            ]);

            // Update invoice status if fully paid
            if ($validated['jumlah'] >= $invoice->total) {
                $invoice->update(['status' => 'lunas']);
            } else {
                $invoice->update(['status' => 'dibayar_sebagian']);
            }

            DB::commit();

            return redirect()->route('billing.show', $invoice)
                ->with('success', 'Pembayaran berhasil diproses dengan nomor: ' . $payment->nomor_pembayaran);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage())->withInput();
        }
    }

    public function showMultiplePayment(Request $request)
    {
        $invoiceIds = $request->input('invoice_ids');
        if (is_string($invoiceIds)) {
            $invoiceIds = json_decode($invoiceIds, true);
        }

        if (empty($invoiceIds) || !is_array($invoiceIds)) {
            return redirect()->route('billing.index')
                ->with('error', 'Tidak ada invoice yang dipilih');
        }

        $invoices = Invoice::with(['pasien', 'itemTagihan'])
            ->whereIn('id', $invoiceIds)
            ->where('status', 'belum_dibayar')
            ->get();

        if ($invoices->isEmpty()) {
            return redirect()->route('billing.index')
                ->with('error', 'Tidak ada invoice yang valid untuk dibayar');
        }

        $totalAmount = $invoices->sum('total');
        $patient = $invoices->first()->pasien;

        return view('billing.payment-multiple-detail', compact('invoices', 'totalAmount', 'patient'));
    }

    public function paymentMultiple(Request $request)
    {
        // Decode JSON array if sent as string
        $invoiceIds = $request->input('tagihan_ids');
        if (is_string($invoiceIds)) {
            $invoiceIds = json_decode($invoiceIds, true);
        }

        $validated = $request->validate([
            'metode_pembayaran' => ['required', Rule::in(Payment::PAYMENT_METHODS)],
            'tanggal_pembayaran' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        if (empty($invoiceIds) || !is_array($invoiceIds)) {
            return back()->with('error', 'Tidak ada invoice yang dipilih')->withInput();
        }

        DB::beginTransaction();
        try {
            $invoices = Invoice::whereIn('id', $invoiceIds)
                ->where('status', 'belum_dibayar')
                ->get();

            if ($invoices->isEmpty()) {
                return back()->with('error', 'Tidak ada invoice yang valid untuk dibayar')->withInput();
            }

            $totalAmount = $invoices->sum('total');

            // Create separate payment for each invoice
            $paymentIds = [];
            foreach ($invoices as $invoice) {
                $payment = Payment::create([
                    'tagihan_id' => $invoice->id,
                    'jumlah' => $invoice->total,
                    'metode_pembayaran' => $validated['metode_pembayaran'],
                    'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
                    'catatan' => $validated['catatan'] ?? null,
                    'diterima_oleh' => Auth::id(),
                ]);
                $paymentIds[] = $payment->id;

                // Update invoice to paid
                $invoice->update(['status' => 'lunas']);
            }

            DB::commit();

            // Redirect to success page with payment IDs
            return redirect()->route('billing.payment-multiple.success', ['payment_ids' => implode(',', $paymentIds)])
                ->with('success', "✅ Pembayaran {$invoices->count()} invoice berhasil diproses! Total: Rp " . number_format($totalAmount, 0, ',', '.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage())->withInput();
        }
    }

    public function showPaymentSuccess(Request $request)
    {
        $paymentIdsString = $request->query('payment_ids');
        if (!$paymentIdsString) {
            return redirect()->route('billing.index')
                ->with('error', 'Invalid payment session');
        }

        $paymentIds = explode(',', $paymentIdsString);
        $payments = Payment::with(['tagihan.pasien', 'tagihan.itemTagihan', 'diterimaOleh'])
            ->whereIn('id', $paymentIds)
            ->get();

        if ($payments->isEmpty()) {
            return redirect()->route('billing.index')
                ->with('error', 'Payment records not found');
        }

        $totalAmount = $payments->sum('jumlah');
        $patient = $payments->first()->tagihan->pasien;
        $paymentMethod = $payments->first()->metode_pembayaran;
        $paymentDate = $payments->first()->tanggal_pembayaran;
        $processedBy = $payments->first()->diterimaOleh;

        return view('billing.payment-multiple-success', compact(
            'payments',
            'totalAmount',
            'patient',
            'paymentMethod',
            'paymentDate',
            'processedBy'
        ));
    }

    public function paymentMultipleMidtrans(Request $request, MidtransService $midtrans)
    {
        $invoiceIds = $request->input('tagihan_ids');
        if (is_string($invoiceIds)) {
            $invoiceIds = json_decode($invoiceIds, true);
        }

        if (empty($invoiceIds) || !is_array($invoiceIds)) {
            return back()->with('error', 'Tidak ada invoice yang dipilih')->withInput();
        }

        $invoices = Invoice::with('pasien')
            ->whereIn('id', $invoiceIds)
            ->where('status', 'belum_dibayar')
            ->get();

        if ($invoices->isEmpty()) {
            return back()->with('error', 'Tidak ada invoice yang valid untuk dibayar')->withInput();
        }

        // Get customer details from first invoice's patient
        $firstInvoice = $invoices->first();
        $patient = $firstInvoice->pasien;

        // Create Midtrans Snap Token
        $result = $midtrans->createMultipleSnapToken(
            $invoices,
            $patient->nama,
            $patient->email,
            $patient->telepon
        );

        if (!$result['success']) {
            return back()->with('error', 'Gagal membuat pembayaran: ' . $result['message'])->withInput();
        }

        // Store invoice IDs in session for callback handling
        session([
            'pending_multiple_payment' => [
                'order_id' => $result['order_id'],
                'invoice_ids' => $invoiceIds,
                'total' => $invoices->sum('total'),
            ]
        ]);

        // Return view with Snap token
        return view('billing.payment-multiple-midtrans', [
            'snapToken' => $result['token'],
            'clientKey' => $midtrans->getClientKey(),
            'snapUrl' => $midtrans->getSnapUrl(),
            'invoices' => $invoices,
            'totalAmount' => $invoices->sum('total'),
        ]);
    }

    public function paymentMultipleSuccess(Request $request, MidtransService $midtrans)
    {
        $orderId = $request->query('order_id');
        $pendingPayment = session('pending_multiple_payment');

        if (!$pendingPayment || $pendingPayment['order_id'] !== $orderId) {
            return redirect()->route('billing.index')
                ->with('error', 'Invalid payment session');
        }

        // Get transaction status from Midtrans
        $status = $midtrans->getTransactionStatus($orderId);

        if (!$status) {
            return redirect()->route('billing.index')
                ->with('warning', 'Tidak dapat memverifikasi status pembayaran. Silakan cek kembali nanti.');
        }

        $transactionStatus = $status['transaction_status'] ?? '';
        $fraudStatus = $status['fraud_status'] ?? 'accept';

        Log::info('Multiple Payment Midtrans Status', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
        ]);

        // Handle successful payment
        if (in_array($transactionStatus, ['capture', 'settlement']) && $fraudStatus === 'accept') {
            DB::beginTransaction();
            try {
                $invoices = Invoice::whereIn('id', $pendingPayment['invoice_ids'])->get();

                // Create payments for each invoice
                $paymentIds = [];
                foreach ($invoices as $invoice) {
                    $payment = Payment::create([
                        'tagihan_id' => $invoice->id,
                        'jumlah' => $invoice->total,
                        'metode_pembayaran' => 'online',
                        'tanggal_pembayaran' => now(),
                        'catatan' => 'Pembayaran Online via Midtrans - Order ID: ' . $orderId,
                        'diterima_oleh' => Auth::id(),
                    ]);
                    $paymentIds[] = $payment->id;

                    $invoice->update(['status' => 'lunas']);
                }

                DB::commit();

                // Clear session
                session()->forget('pending_multiple_payment');

                return redirect()->route('billing.payment-multiple.success', ['payment_ids' => implode(',', $paymentIds)])
                    ->with('success', "✅ Pembayaran {$invoices->count()} invoice berhasil! Total: Rp " . number_format($pendingPayment['total'], 0, ',', '.'));
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Multiple Payment Processing Failed', [
                    'error' => $e->getMessage(),
                    'order_id' => $orderId,
                ]);

                return redirect()->route('billing.index')
                    ->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
            }
        }

        // Handle pending/failed payment
        $message = match($transactionStatus) {
            'pending' => 'Pembayaran menunggu konfirmasi',
            'deny' => 'Pembayaran ditolak',
            'cancel', 'expire' => 'Pembayaran dibatalkan atau kadaluarsa',
            default => 'Status pembayaran: ' . $transactionStatus,
        };

        return redirect()->route('billing.index')
            ->with('warning', $message);
    }

    public function payments(Request $request)
    {
        $query = Payment::with(['tagihan', 'diterimaOleh']);

        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        $payments = $query->latest('tanggal_pembayaran')->paginate(20);

        return view('billing.payments', compact('payments'));
    }
}
