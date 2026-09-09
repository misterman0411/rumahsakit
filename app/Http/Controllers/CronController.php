<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/**
 * HTTP entry points for Vercel Cron.
 *
 * Vercel has no in-process cron daemon — instead, it sends a GET request to
 * a configured route on a schedule, which then re-enters the Laravel app
 * to run the same Artisan command that used to run via `schedule:run`.
 *
 * The CRON_SECRET env variable gates access so the routes are not callable
 * by random visitors. Vercel's cron jobs automatically include the token in
 * the Authorization header.
 *
 * @see https://vercel.com/docs/cron-jobs
 */
class CronController extends Controller
{
    /**
     * Daily room-charge sweep (was previously scheduled in routes/console.php).
     *
     * Path: /api/cron/charge-rooms
     * Suggested schedule in vercel.json: "1 0 * * *" (00:01 UTC daily).
     */
    public function chargeRooms(Request $request): JsonResponse
    {
        if (! $this->authorized($request)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $exitCode = Artisan::call('inpatient:charge-rooms-daily');
        $output = Artisan::output();

        return response()->json([
            'status' => $exitCode === 0 ? 'ok' : 'error',
            'exit_code' => $exitCode,
            'output' => trim($output),
        ]);
    }

    /**
     * Verify the Authorization header against CRON_SECRET.
     */
    protected function authorized(Request $request): bool
    {
        $secret = (string) env('CRON_SECRET');

        // If no secret is configured, allow the call (local/dev convenience).
        if ($secret === '') {
            return true;
        }

        $header = (string) $request->header('Authorization', '');

        return $header === 'Bearer '.$secret;
    }
}
