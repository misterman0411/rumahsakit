<?php
/**
 * Vercel serverless entry point.
 */

ini_set('display_errors', '1');
ini_set('log_errors', '1');
error_reporting(E_ALL);

// Wipe any stale services.php that might have been shipped with the build
// cache from a previous environment (dev providers that no longer exist).
$bootstrapCache = dirname(__DIR__) . '/bootstrap/cache';
foreach (['services.php', 'packages.php', 'config.php', 'routes-v7.php'] as $f) {
    $p = $bootstrapCache . '/' . $f;
    if (is_file($p)) {
        @unlink($p);
    }
}

// Force Laravel to rebuild its manifest on first call by also setting the
// cached providers path to a non-existent file. Laravel checks
// file_exists() on this path before loading.
@touch($bootstrapCache . '/.force-rebuild');

require_once __DIR__ . '/../public/index.php';
