<?php
/**
 * Vercel serverless entry point.
 *
 * The Vercel build cache can ship a stale bootstrap/cache/services.php
 * from a previous environment. If the cached manifest references a
 * provider that no longer exists in vendor/ (e.g. moved from dev to
 * prod, or vice versa), Laravel crashes during bootstrap. Wipe the
 * cached providers manifest before delegating to public/index.php so
 * Laravel rediscovers providers from the actual composer autoloader.
 */

$bootstrapCache = dirname(__DIR__) . '/bootstrap/cache';
foreach (['services.php', 'packages.php', 'config.php', 'routes-v7.php'] as $f) {
    $p = $bootstrapCache . '/' . $f;
    if (is_file($p)) {
        @unlink($p);
    }
}

require_once __DIR__ . '/../public/index.php';
