<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Midtrans Payment Gateway integration.
    | Store sensitive keys in .env file for security.
    |
    */

    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    
    'is_3ds' => env('MIDTRANS_IS_3DS', true),

    /*
    |--------------------------------------------------------------------------
    | Notification URL
    |--------------------------------------------------------------------------
    |
    | URL for Midtrans to send payment notifications
    |
    */
    'notification_url' => env('APP_URL') . '/api/midtrans/notification',

    /*
    |--------------------------------------------------------------------------
    | Redirect URLs
    |--------------------------------------------------------------------------
    */
    'finish_url' => env('APP_URL') . '/billing/payment-success',
    'unfinish_url' => env('APP_URL') . '/billing/payment-pending',
    'error_url' => env('APP_URL') . '/billing/payment-failed',
];
