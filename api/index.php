<?php
/**
 * Vercel serverless entry point.
 *
 * Vercel invokes this file for every non-static request, then delegates to
 * the standard Laravel front controller in public/index.php. All HTTP
 * variables are populated by Vercel's router before this script runs.
 *
 * A boot probe runs first so a misconfigured deployment fails loudly with
 * the missing env var name. We log to THREE channels because Vercel
 * sometimes truncates or hides stderr in the dashboard:
 *
 *   1. stderr (error_log)         — primary, normally visible in Vercel logs
 *   2. /tmp/_vercel_probe.json    — survives even if stderr is swallowed
 *   3. response body              — last resort, only shown when fatal
 */

// Force PHP to flush stderr immediately so probe output appears in Vercel
// logs even when Laravel throws a fatal error during bootstrap.
ini_set('display_errors', '1');
ini_set('log_errors', '1');

$probe = [
    'php'        => PHP_VERSION,
    'app_key'    => getenv('APP_KEY')      !== false ? 'set' : 'MISSING',
    'app_url'    => getenv('APP_URL')      ?: 'MISSING',
    'app_env'    => getenv('APP_ENV')      ?: 'MISSING',
    'app_debug'  => getenv('APP_DEBUG')    ?: 'MISSING',
    'db_host'    => getenv('DB_HOST')      ?: 'MISSING',
    'db_port'    => getenv('DB_PORT')      ?: 'MISSING',
    'db_name'    => getenv('DB_DATABASE')  ?: 'MISSING',
    'db_user'    => getenv('DB_USERNAME')  ?: 'MISSING',
    'session'    => getenv('SESSION_DRIVER')   ?: 'MISSING',
    'cache'      => getenv('CACHE_STORE')       ?: 'MISSING',
    'queue'      => getenv('QUEUE_CONNECTION')  ?: 'MISSING',
    'fs_disk'    => getenv('FILESYSTEM_DISK')   ?: 'MISSING',
    'blob_tok'   => getenv('BLOB_READ_WRITE_TOKEN') !== false ? 'set' : 'MISSING',
    'cron_secret'=> getenv('CRON_SECRET')  !== false ? 'set' : 'MISSING',
];

$probeJson = json_encode($probe, JSON_UNESCAPED_SLASHES);

// Channel 1: stderr (Vercel normally surfaces this in the Logs tab)
error_log('[vercel-php probe] ' . $probeJson);

// Channel 2: /tmp file (writable on Vercel, survives even if the script dies)
@file_put_contents('/tmp/_vercel_probe.json', $probeJson);

// Hand off to Laravel.
require_once __DIR__ . '/../public/index.php';
