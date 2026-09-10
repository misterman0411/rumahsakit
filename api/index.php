<?php
/**
 * Vercel serverless entry point.
 *
 * Delegates to the standard Laravel front controller at public/index.php.
 * Keep this file as small as possible — every extra line here runs on
 * every cold start, and we want cold starts to be fast.
 */

require_once __DIR__ . '/../public/index.php';
