<?php
/**
 * Vercel serverless entry point.
 *
 * Vercel invokes this file for every non-static request, then delegates to the
 * standard Laravel front controller in public/index.php. All HTTP variables
 * ($_SERVER, $_GET, $_POST, headers, body) are populated by Vercel's router
 * before this script runs, so the require chain Just Works.
 *
 * A small boot probe runs first so a misconfigured deployment fails loudly
 * with the missing env var name in stderr — Laravel's own error logger is
 * not yet wired up at the point where the most common early failures
 * (APP_KEY missing, APP_URL wrong) occur, so without this probe the
 * function log just shows an empty 500.
 */

// Probe: emit a structured summary of the deployment environment to stderr
// so it appears in Vercel → Logs alongside the actual Laravel error below.
$probe = [
    'php'      => PHP_VERSION,
    'app_key'  => getenv('APP_KEY') !== false ? 'set' : 'MISSING',
    'app_url'  => getenv('APP_URL') ?: 'MISSING',
    'app_env'  => getenv('APP_ENV') ?: 'MISSING',
    'app_debug'=> getenv('APP_DEBUG') ?: 'MISSING',
    'db_host'  => getenv('DB_HOST') ?: 'MISSING',
    'db_port'  => getenv('DB_PORT') ?: 'MISSING',
    'db_name'  => getenv('DB_DATABASE') ?: 'MISSING',
    'db_user'  => getenv('DB_USERNAME') ?: 'MISSING',
    'session'  => getenv('SESSION_DRIVER') ?: 'MISSING',
    'cache'    => getenv('CACHE_STORE') ?: 'MISSING',
    'queue'    => getenv('QUEUE_CONNECTION') ?: 'MISSING',
    'fs_disk'  => getenv('FILESYSTEM_DISK') ?: 'MISSING',
    'blob_tok' => getenv('BLOB_READ_WRITE_TOKEN') !== false ? 'set' : 'MISSING',
];
error_log('[vercel-php probe] ' . json_encode($probe));

require_once __DIR__ . '/../public/index.php';
