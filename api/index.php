<?php
/**
 * Vercel serverless entry point.
 *
 * Vercel invokes this file for every non-static request, then delegates to the
 * standard Laravel front controller in public/index.php. All HTTP variables
 * ($_SERVER, $_GET, $_POST, headers, body) are populated by Vercel's router
 * before this script runs, so the require chain Just Works.
 */
require_once __DIR__ . '/../public/index.php';
