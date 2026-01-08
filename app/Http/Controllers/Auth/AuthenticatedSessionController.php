<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(Request $request)
    {
        $email = old('email', '');
        $ipAddress = $request->ip();
        $attemptInfo = [];

        if ($email) {
            $attempt = LoginAttempt::where('email', $email)
                ->where('ip_address', $ipAddress)
                ->first();

            if ($attempt) {
                $attemptInfo = [
                    'attempts' => $attempt->attempts,
                    'remaining' => max(0, 5 - $attempt->attempts),
                    'is_locked' => LoginAttempt::isLocked($email, $ipAddress),
                    'locked_minutes' => LoginAttempt::getLockedMinutesRemaining($email, $ipAddress),
                    'locked_until' => $attempt->locked_until ? $attempt->locked_until->toIso8601String() : null,
                ];
            }
        }

        return view('auth.login', ['attemptInfo' => $attemptInfo]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        $email = $request->input('email');
        $ipAddress = $request->ip();

        // Cek apakah akun sudah di-lock
        if (LoginAttempt::isLocked($email, $ipAddress)) {
            return back()->onlyInput('email');
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah email ada di database
        $userExists = User::where('email', $email)->exists();
        if (!$userExists) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar. Silakan buat akun baru terlebih dahulu.',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Reset attempts ketika login berhasil
            LoginAttempt::resetAttempts($email, $ipAddress);
            $request->session()->regenerate();

            $user = Auth::user();
            $staffRoles = [
                'admin', 'doctor', 'nurse', 'front_office', 
                'pharmacist', 'lab_technician', 'radiologist', 
                'cashier', 'management'
            ];

            if ($user->hasAnyRole($staffRoles)) {
                return redirect()->intended(route('dashboard'));
            }

            return redirect()->intended(route('home'));
        }

        // Record failed attempt
        LoginAttempt::recordAttempt($email, $ipAddress);
        
        // Cek lagi apakah baru di-lock setelah attempt ini
        if (LoginAttempt::isLocked($email, $ipAddress)) {
            return back()->onlyInput('email');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Display the confirm logout other devices view.
     */
    public function confirmLogoutOtherDevices()
    {
        return view('auth.confirm-logout-other-devices');
    }

    /**
     * Log out from other devices.
     */
    public function destroyOtherDevices(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        Auth::logoutOtherDevices($request->password);

        return back()->with('status', 'Logged out of other devices.');
    }
}
