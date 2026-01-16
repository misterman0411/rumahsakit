<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MidtransService
{
    protected $serverKey;
    protected $clientKey;
    protected $isProduction;
    protected $baseUrl;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->clientKey = config('midtrans.client_key');
        $this->isProduction = config('midtrans.is_production', false);
        $this->baseUrl = $this->isProduction 
            ? 'https://api.midtrans.com/v2' 
            : 'https://api.sandbox.midtrans.com/v2';
    }

    /**
     * Create Snap Token for payment
     */
    public function createSnapToken($invoice)
    {
        $orderId = 'INV-' . $invoice->id . '-' . time();
        
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $invoice->total,
            ],
            'customer_details' => [
                'first_name' => $invoice->pasien->nama,
                'email' => $invoice->pasien->email ?? 'noreply@hospital.com',
                'phone' => $invoice->pasien->telepon ?? '08123456789',
            ],
            'item_details' => $this->getItemDetails($invoice),
            'callbacks' => [
                'finish' => route('patient.payment.success') . '?order_id=' . $orderId,
            ],
        ];

        Log::info('Midtrans Request Params', [
            'params' => $params,
            'app_url' => config('app.url'),
        ]);

        try {
            $snapUrl = $this->isProduction 
                ? 'https://app.midtrans.com/snap/v1/transactions' 
                : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
            
            $response = Http::withBasicAuth($this->serverKey, '')
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($snapUrl, $params);

            if ($response->successful()) {
                $result = $response->json();
                
                // Log transaction
                Log::info('Midtrans Snap Token Created', [
                    'order_id' => $orderId,
                    'invoice_id' => $invoice->id,
                    'token' => $result['token'] ?? null,
                ]);

                return [
                    'success' => true,
                    'token' => $result['token'] ?? null,
                    'redirect_url' => $result['redirect_url'] ?? null,
                    'order_id' => $orderId,
                ];
            }

            Log::error('Midtrans Snap Token Failed', [
                'status' => $response->status(),
                'response' => $response->json(),
            ]);

            return [
                'success' => false,
                'message' => $response->json()['error_messages'][0] ?? 'Failed to create payment',
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment gateway error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get item details from invoice
     */
    protected function getItemDetails($invoice)
    {
        $items = [];

        // Main item: use total as single line item
        // This ensures gross_amount matches item_details total
        $items[] = [
            'id' => 'INV-' . $invoice->id,
            'price' => (int) $invoice->total,
            'quantity' => 1,
            'name' => 'Hospital Invoice #' . $invoice->nomor_tagihan,
        ];

        return $items;
    }

    /**
     * Create Snap Token for multiple invoices payment
     */
    public function createMultipleSnapToken($invoices, $customerName, $customerEmail = null, $customerPhone = null)
    {
        $orderId = 'MULTI-INV-' . time();
        $totalAmount = $invoices->sum('total');
        
        // Create item details for each invoice
        $itemDetails = [];
        foreach ($invoices as $invoice) {
            $itemDetails[] = [
                'id' => 'INV-' . $invoice->id,
                'price' => (int) $invoice->total,
                'quantity' => 1,
                'name' => 'Invoice #' . $invoice->nomor_tagihan,
            ];
        }
        
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $totalAmount,
            ],
            'customer_details' => [
                'first_name' => $customerName,
                'email' => $customerEmail ?? 'noreply@hospital.com',
                'phone' => $customerPhone ?? '08123456789',
            ],
            'item_details' => $itemDetails,
            'callbacks' => [
                'finish' => route('billing.payment-multiple-success') . '?order_id=' . $orderId,
            ],
            'custom_field1' => implode(',', $invoices->pluck('id')->toArray()), // Store invoice IDs
        ];

        Log::info('Midtrans Multiple Payment Request', [
            'params' => $params,
            'invoice_count' => $invoices->count(),
        ]);

        try {
            $snapUrl = $this->isProduction 
                ? 'https://app.midtrans.com/snap/v1/transactions' 
                : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
            
            $response = Http::withBasicAuth($this->serverKey, '')
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])
                ->post($snapUrl, $params);

            if ($response->successful()) {
                $result = $response->json();
                
                Log::info('Midtrans Multiple Snap Token Created', [
                    'order_id' => $orderId,
                    'invoice_count' => $invoices->count(),
                    'token' => $result['token'] ?? null,
                ]);

                return [
                    'success' => true,
                    'token' => $result['token'] ?? null,
                    'redirect_url' => $result['redirect_url'] ?? null,
                    'order_id' => $orderId,
                ];
            }

            Log::error('Midtrans Multiple Snap Token Failed', [
                'status' => $response->status(),
                'response' => $response->json(),
            ]);

            return [
                'success' => false,
                'message' => $response->json()['error_messages'][0] ?? 'Failed to create payment',
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Multiple Payment Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Payment gateway error: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Verify notification from Midtrans
     */
    public function verifyNotification($payload)
    {
        $orderId = $payload['order_id'] ?? null;
        $statusCode = $payload['status_code'] ?? null;
        $grossAmount = $payload['gross_amount'] ?? null;
        $signatureKey = $payload['signature_key'] ?? null;

        // Verify signature
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);

        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans Invalid Signature', [
                'order_id' => $orderId,
                'expected' => $expectedSignature,
                'received' => $signatureKey,
            ]);
            return false;
        }

        return true;
    }

    /**
     * Get transaction status
     */
    public function getTransactionStatus($orderId)
    {
        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->get($this->baseUrl . '/' . $orderId . '/status');

            if ($response->successful()) {
                $result = $response->json();
                
                Log::info('Midtrans Transaction Status Retrieved', [
                    'order_id' => $orderId,
                    'status' => $result['transaction_status'] ?? null,
                ]);

                return [
                    'success' => true,
                    'transaction_status' => $result['transaction_status'] ?? null,
                    'payment_type' => $result['payment_type'] ?? null,
                    'gross_amount' => $result['gross_amount'] ?? null,
                    'fraud_status' => $result['fraud_status'] ?? 'accept',
                ];
            }

            Log::error('Midtrans Status Check Failed', [
                'order_id' => $orderId,
                'status' => $response->status(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to get transaction status',
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Get Status Failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
            
            return [
                'success' => false,
                'message' => 'Error checking transaction status: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Cancel transaction
     */
    public function cancelTransaction($orderId)
    {
        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->post($this->baseUrl . '/' . $orderId . '/cancel');

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Midtrans Cancel Failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Get client key for frontend
     */
    public function getClientKey()
    {
        return $this->clientKey;
    }

    /**
     * Get snap URL for frontend
     */
    public function getSnapUrl()
    {
        return $this->isProduction
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }
}
