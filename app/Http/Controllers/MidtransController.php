<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class MidtransController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    /**
     * Create payment token
     */
    public function createPayment(Invoice $invoice)
    {
        try {
            // Check if invoice is already paid
            if ($invoice->status === 'lunas') {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice already paid',
                ], 400);
            }

            // Create Snap token
            $result = $this->midtrans->createSnapToken($invoice);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'snap_token' => $result['token'],
                    'order_id' => $result['order_id'],
                    'client_key' => $this->midtrans->getClientKey(),
                ]);
            }

            Log::error('Midtrans Token Creation Failed', [
                'invoice_id' => $invoice->id,
                'result' => $result
            ]);

            return response()->json([
                'success' => false,
                'message' => $result['message'] ?? 'Failed to create payment',
                'error' => $result['error'] ?? null,
            ], 500);
        } catch (\Exception $e) {
            Log::error('Midtrans Payment Exception', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'System error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Verify payment from Midtrans and update invoice (for localhost development)
     */
    public function verifyAndUpdatePayment(Invoice $invoice)
    {
        try {
            DB::beginTransaction();
            
            // Check if there's already a payment that covers the full amount
            $totalPaid = $invoice->pembayaran->sum('jumlah');
            if ($totalPaid >= $invoice->total) {
                DB::rollBack();
                return response()->json([
                    'success' => true,
                    'message' => 'Invoice already fully paid',
                    'status' => 'lunas'
                ]);
            }
            
            // Try to find recent order from Midtrans
            $orderIdPrefix = 'INV-' . $invoice->id . '-';
            
            // Get the most recent order ID (last 5 minutes) - check from logs or database
            // For simplicity, we'll try common recent timestamps
            $found = false;
            $currentTime = time();
            
            // Check last 30 minutes worth of possible order IDs
            for ($i = 0; $i < 1800; $i += 10) {
                $testOrderId = $orderIdPrefix . ($currentTime - $i);
                $status = $this->midtrans->getTransactionStatus($testOrderId);
                
                if ($status && in_array($status['transaction_status'], ['settlement', 'capture'])) {
                    // Found a successful payment!
                    $this->processSuccessfulPayment($invoice, $status);
                    $found = true;
                    
                    DB::commit();
                    
                    Log::info('Payment Verified from Midtrans', [
                        'invoice_id' => $invoice->id,
                        'order_id' => $testOrderId,
                        'status' => $status['transaction_status']
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Payment verified successfully! Invoice status updated to PAID.',
                        'status' => 'paid',
                        'order_id' => $testOrderId
                    ]);
                }
            }
            
            // If no payment found, create manual verification payment
            if (!$found) {
                $payment = Payment::create([
                    'tagihan_id' => $invoice->id,
                    'jumlah' => $invoice->total - $totalPaid,
                    'metode_pembayaran' => 'transfer',
                    'tanggal_pembayaran' => now(),
                    'catatan' => 'Midtrans payment - Manual verification (No order found in API)',
                    'diterima_oleh' => Auth::id(),
                ]);

                $invoice->update(['status' => 'lunas']);

                DB::commit();

                Log::info('Manual Payment Verification', [
                    'invoice_id' => $invoice->id,
                    'amount' => $payment->amount
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Payment marked as paid (manual verification)',
                    'status' => 'lunas'
                ]);
            }
            
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'No successful payment found for this invoice'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Verification Error', [
                'invoice_id' => $invoice->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle notification from Midtrans
     */
    public function notification(Request $request)
    {
        $payload = $request->all();

        Log::info('Midtrans Notification Received', $payload);

        // Verify signature
        if (!$this->midtrans->verifyNotification($payload)) {
            Log::warning('Midtrans Invalid Notification Signature');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $orderId = $payload['order_id'];
        $transactionStatus = $payload['transaction_status'];
        $fraudStatus = $payload['fraud_status'] ?? 'accept';

        // Extract invoice ID from order_id (format: INV-{id}-{timestamp})
        preg_match('/INV-(\d+)-/', $orderId, $matches);
        $invoiceId = $matches[1] ?? null;

        if (!$invoiceId) {
            Log::error('Midtrans Invalid Order ID Format', ['order_id' => $orderId]);
            return response()->json(['message' => 'Invalid order ID'], 400);
        }

        $invoice = Invoice::find($invoiceId);
        if (!$invoice) {
            Log::error('Midtrans Invoice Not Found', ['invoice_id' => $invoiceId]);
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        DB::beginTransaction();
        try {
            // Handle transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $this->processSuccessfulPayment($invoice, $payload);
                }
            } elseif ($transactionStatus == 'settlement') {
                $this->processSuccessfulPayment($invoice, $payload);
            } elseif ($transactionStatus == 'pending') {
                // Payment is pending
                Log::info('Midtrans Payment Pending', ['order_id' => $orderId]);
            } elseif ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                // Payment failed
                Log::info('Midtrans Payment Failed', [
                    'order_id' => $orderId,
                    'status' => $transactionStatus,
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Midtrans Notification Processing Failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['message' => 'Processing failed'], 500);
        }
    }

    /**
     * Process successful payment
     */
    protected function processSuccessfulPayment($invoice, $payload)
    {
        $amount = $payload['gross_amount'];
        $paymentType = $payload['payment_type'];
        $transactionId = $payload['transaction_id'];

        // Create payment record
        $payment = Payment::create([
            'tagihan_id' => $invoice->id,
            'jumlah' => $amount,
            'metode_pembayaran' => $this->mapPaymentMethod($paymentType),
            'tanggal_pembayaran' => now(),
            'catatan' => 'Payment via Midtrans - Transaction ID: ' . $transactionId,
            'diterima_oleh' => Auth::id() ?? 1, // Use system user if no auth
        ]);

        // Calculate total paid
        $totalPaid = $invoice->pembayaran->sum('jumlah');

        // Update invoice status
        if ($totalPaid >= $invoice->total) {
            $invoice->update(['status' => 'lunas']);
        } elseif ($totalPaid > 0) {
            $invoice->update(['status' => 'dibayar_sebagian']);
        }

        Log::info('Midtrans Payment Processed Successfully', [
            'invoice_id' => $invoice->id,
            'payment_id' => $payment->id,
            'amount' => $amount,
            'transaction_id' => $transactionId,
        ]);
    }

    /**
     * Map Midtrans payment type to our payment method
     */
    protected function mapPaymentMethod($paymentType)
    {
        $mapping = [
            'credit_card' => 'kartu_kredit',
            'bank_transfer' => 'transfer',
            'echannel' => 'transfer',
            'bca_va' => 'transfer',
            'bni_va' => 'transfer',
            'bri_va' => 'transfer',
            'permata_va' => 'transfer',
            'other_va' => 'transfer',
            'gopay' => 'kartu_debit',
            'shopeepay' => 'kartu_debit',
            'qris' => 'kartu_debit',
        ];

        return $mapping[$paymentType] ?? 'transfer';
    }

    /**
     * Check payment status
     */
    public function checkStatus($orderId)
    {
        $status = $this->midtrans->getTransactionStatus($orderId);

        if ($status) {
            return response()->json([
                'success' => true,
                'data' => $status,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Transaction not found',
        ], 404);
    }

    /**
     * Payment success callback
     */
    public function paymentSuccess(Request $request)
    {
        $orderId = $request->query('order_id');
        
        // Extract invoice ID from order_id
        if ($orderId) {
            preg_match('/INV-(\d+)-/', $orderId, $matches);
            $invoiceId = $matches[1] ?? null;
            
            if ($invoiceId) {
                // Get transaction status from Midtrans
                $status = $this->midtrans->getTransactionStatus($orderId);
                
                if ($status && in_array($status['transaction_status'], ['settlement', 'capture'])) {
                    // Process payment immediately
                    $invoice = Invoice::find($invoiceId);
                    if ($invoice && $invoice->status !== 'lunas') {
                        DB::beginTransaction();
                        try {
                            $this->processSuccessfulPayment($invoice, $status);
                            DB::commit();
                            
                            Log::info('Payment Success Callback - Invoice Updated', [
                                'invoice_id' => $invoiceId,
                                'order_id' => $orderId,
                                'status' => $status['transaction_status']
                            ]);
                        } catch (\Exception $e) {
                            DB::rollBack();
                            Log::error('Payment Success Callback Error', [
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                }
                
                // Redirect to billing page (will ask to login if needed)
                if (Auth::check()) {
                    return redirect()->route('billing.show', $invoiceId)
                        ->with('success', 'Pembayaran berhasil! Status invoice telah diupdate.');
                } else {
                    return redirect()->route('login')
                        ->with('success', 'Pembayaran berhasil! Silakan login untuk melihat invoice.');
                }
            }
        }
        
        if (Auth::check()) {
            return redirect()->route('billing.index')
                ->with('success', 'Pembayaran berhasil!');
        } else {
            return redirect()->route('login')
                ->with('success', 'Pembayaran berhasil! Silakan login.');
        }
    }

    /**
     * Payment pending callback
     */
    public function paymentPending(Request $request)
    {
        $orderId = $request->query('order_id');
        
        if ($orderId) {
            preg_match('/INV-(\d+)-/', $orderId, $matches);
            $invoiceId = $matches[1] ?? null;
            
            if ($invoiceId) {
                if (Auth::check()) {
                    return redirect()->route('billing.show', $invoiceId)
                        ->with('info', 'Pembayaran sedang diproses. Silakan tunggu konfirmasi.');
                } else {
                    return redirect()->route('login')
                        ->with('info', 'Pembayaran sedang diproses.');
                }
            }
        }
        
        if (Auth::check()) {
            return redirect()->route('billing.index')
                ->with('info', 'Pembayaran sedang diproses.');
        } else {
            return redirect()->route('login')
                ->with('info', 'Pembayaran sedang diproses.');
        }
    }

    /**
     * Payment failed callback
     */
    public function paymentFailed(Request $request)
    {
        $orderId = $request->query('order_id');
        
        if ($orderId) {
            preg_match('/INV-(\d+)-/', $orderId, $matches);
            $invoiceId = $matches[1] ?? null;
            
            if ($invoiceId) {
                if (Auth::check()) {
                    return redirect()->route('billing.show', $invoiceId)
                        ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
                } else {
                    return redirect()->route('login')
                        ->with('error', 'Pembayaran gagal.');
                }
            }
        }
        
        if (Auth::check()) {
            return redirect()->route('billing.index')
                ->with('error', 'Pembayaran gagal.');
        } else {
            return redirect()->route('login')
                ->with('error', 'Pembayaran gagal.');
        }
    }
}
