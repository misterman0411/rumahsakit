<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LoginAttempt extends Model
{
    protected $fillable = ['email', 'ip_address', 'attempts', 'locked_until'];
    
    protected $casts = [
        'locked_until' => 'datetime',
    ];

    /**
     * Increment login attempts untuk email dan IP tertentu
     */
    public static function recordAttempt(string $email, string $ipAddress): self
    {
        $attempt = self::firstOrCreate(
            ['email' => $email, 'ip_address' => $ipAddress],
            ['attempts' => 0, 'locked_until' => null]
        );

        $attempt->increment('attempts');
        
        // Jika sudah 5 kali, lock selama 1 menit
        if ($attempt->attempts >= 5) {
            $attempt->update(['locked_until' => now()->addMinutes(1)]);
        }

        return $attempt;
    }

    /**
     * Check apakah akun sudah di-lock
     */
    public static function isLocked(string $email, string $ipAddress): bool
    {
        $attempt = self::where('email', $email)
            ->where('ip_address', $ipAddress)
            ->first();

        if (!$attempt) {
            return false;
        }

        // Jika sudah melewati waktu lock, reset
        if ($attempt->locked_until && $attempt->locked_until <= now()) {
            $attempt->update([
                'attempts' => 2,
                'locked_until' => null
            ]);
            return false;
        }

        return $attempt->locked_until !== null && $attempt->locked_until > now();
    }

    /**
     * Reset attempts ketika login berhasil
     */
    public static function resetAttempts(string $email, string $ipAddress): void
    {
        self::where('email', $email)
            ->where('ip_address', $ipAddress)
            ->update([
                'attempts' => 0,
                'locked_until' => null
            ]);
    }

    /**
     * Dapatkan sisa waktu lock dalam menit
     */
    public static function getLockedMinutesRemaining(string $email, string $ipAddress): int
    {
        $attempt = self::where('email', $email)
            ->where('ip_address', $ipAddress)
            ->first();

        if (!$attempt || !$attempt->locked_until) {
            return 0;
        }

        $minutes = $attempt->locked_until->diffInMinutes(now(), false);
        return max(0, $minutes);
    }
}