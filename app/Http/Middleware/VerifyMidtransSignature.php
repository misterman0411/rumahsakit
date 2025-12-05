<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class VerifyMidtransSignature
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip verification for non-Midtrans notification routes
        if (!$request->is('api/midtrans/*')) {
            return $next($request);
        }

        $serverKey = config('midtrans.server_key');
        $orderId = $request->input('order_id');
        $statusCode = $request->input('status_code');
        $grossAmount = $request->input('gross_amount');
        $signatureKey = $request->input('signature_key');

        // Generate expected signature
        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        // Verify signature
        if ($signatureKey !== $expectedSignature) {
            Log::warning('Midtrans Invalid Signature Attempt', [
                'ip' => $request->ip(),
                'order_id' => $orderId,
                'expected' => $expectedSignature,
                'received' => $signatureKey,
            ]);

            return response()->json([
                'message' => 'Invalid signature'
            ], 403);
        }

        // Log valid notification
        Log::info('Midtrans Valid Notification', [
            'ip' => $request->ip(),
            'order_id' => $orderId,
            'status_code' => $statusCode,
        ]);

        return $next($request);
    }
}
