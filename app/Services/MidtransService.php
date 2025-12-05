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
                'finish' => route('billing.payment-success') . '?order_id=' . $orderId,
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
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Midtrans Get Status Failed', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
            ]);
            return null;
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
