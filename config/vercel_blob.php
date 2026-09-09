<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Vercel Blob Storage
    |--------------------------------------------------------------------------
    |
    | The application uses Vercel Blob for all user-uploaded files (radiology
    | images, profile photos, etc.) because the Vercel filesystem is read-only
    | and offers no persistent disk. The BLOB_READ_WRITE_TOKEN environment
    | variable is auto-injected by Vercel when you attach a Blob store from
    | the project dashboard (Storage → Create Database → Blob).
    |
    | Documents:
    |   https://vercel.com/docs/storage/vercel-blob
    |
    */

    'token'    => env('BLOB_READ_WRITE_TOKEN'),
    'base_url' => env('VERCEL_BLOB_BASE_URL', 'https://blob.vercel-storage.com'),

    /*
    |--------------------------------------------------------------------------
    | Optional public read-write token
    |--------------------------------------------------------------------------
    |
    | Some flows (admin scripts, queue jobs) may need to upload from outside
    | the main request context. Defaults to the same token as above.
    |
    */

    'rw_token' => env('BLOB_READ_WRITE_TOKEN'),

];
