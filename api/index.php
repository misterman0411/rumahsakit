<?php
/**
 * Vercel serverless entry point.
 *
 * Writes diagnostic info to the response body so we can see what's
 * actually happening in the Vercel runtime (the dashboard sometimes
 * drops stderr entries, but the body is always visible to the browser).
 */

ini_set('display_errors', '1');
ini_set('log_errors', '1');
error_reporting(E_ALL);

$base = dirname(__DIR__);

// Run a minimal probe of the runtime environment. We print BEFORE
// delegating to Laravel so we can see what's there.
$diag = [
    'php'              => PHP_VERSION,
    'app_key_set'      => getenv('APP_KEY') !== false,
    'app_env'          => getenv('APP_ENV') ?: 'unset',
    'app_debug'        => getenv('APP_DEBUG') ?: 'unset',
    'app_url'          => getenv('APP_URL') ?: 'unset',
    'composer_autoload'=> is_file($base . '/vendor/autoload.php'),
    'public_index'     => is_file($base . '/public/index.php'),
    'bootstrap_app'    => is_file($base . '/bootstrap/app.php'),
    'providers_php'    => is_file($base . '/bootstrap/providers.php'),
    'config_dir'       => is_dir($base . '/config'),
    'bootstrap_cache'  => array_values(array_diff(scandir($base . '/bootstrap/cache'), ['.', '..'])),
];

header('Content-Type: text/plain; charset=utf-8');

try {
    require_once __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    echo "\n\n--- BOOT ERROR ---\n";
    echo $e->getMessage() . "\n";
    echo "in " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "\n--- DIAG ---\n";
    echo json_encode($diag, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . "\n";
}
