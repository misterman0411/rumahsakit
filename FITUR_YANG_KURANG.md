# 🚨 Fitur Penting yang Belum Ada di Sistem

**Analisis:** 4 Desember 2025  
**Status:** ⚠️ CRITICAL - Missing Basic Features

---

## ❌ FITUR DASAR YANG TIDAK ADA (WAJIB!)

Setelah analisis, sistem **BELUM PUNYA** fitur-fitur authentication & user management yang WAJIB ada:

### 1. ❌ Forgot Password / Reset Password
### 2. ❌ Email Verification  
### 3. ✅ Remember Me (Stay Logged In)
### 4. ✅ Profile Management (Edit Profile)
### 5. ✅ Change Password (untuk user yang sudah login)
### 6. ✅ Logout dari Semua Device
### 7. ✅ Login Attempt Limiting (Protection dari brute force)
### 8. ❌ Two-Factor Authentication (2FA)

---


### 1. 🔑 Forgot Password & Reset Password
**Kenapa Wajib:**
- User **pasti** akan lupa password
- Tanpa ini, user tidak bisa login lagi
- Admin harus reset manual di database (ribet & tidak aman)

**Yang Harus Dibuat:**

#### A. Database Migration
```php
// database/migrations/xxxx_create_password_reset_tokens_table.php
Schema::create('password_reset_tokens', function (Blueprint $table) {
    $table->string('email')->primary();
    $table->string('token');
    $table->timestamp('created_at')->nullable();
});
```

#### B. Routes (routes/auth.php)
```php
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

// Forgot Password
Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');
    
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

// Reset Password
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');
    
Route::post('reset-password', [NewPasswordController::class, 'store'])
    ->name('password.update');
```

#### C. Controllers

**PasswordResetLinkController.php**
```php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}
```

**NewPasswordController.php**
```php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;

class NewPasswordController extends Controller
{
    public function create(Request $request)
    {
        return view('auth.reset-password', [
            'request' => $request
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password)
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
```

#### D. Views

**forgot-password.blade.php**
```html
<x-guest-layout>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <h2>Lupa Password</h2>
        <p>Masukkan email Anda, kami akan kirim link reset password.</p>
        
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" 
                   value="{{ old('email') }}" required autofocus>
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <button type="submit">Kirim Link Reset Password</button>
        
        <a href="{{ route('login') }}">Kembali ke Login</a>
    </form>
</x-guest-layout>
```

**reset-password.blade.php**
```html
<x-guest-layout>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->token }}">
        
        <h2>Reset Password</h2>

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" 
                   value="{{ old('email', $request->email) }}" required>
            @error('email')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password">Password Baru</label>
            <input id="password" type="password" name="password" required>
            @error('password')
                <span>{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" 
                   name="password_confirmation" required>
        </div>

        <button type="submit">Reset Password</button>
    </form>
</x-guest-layout>
```

#### E. Email Template
**resources/views/emails/reset-password.blade.php**
```html
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
    
    <p>
        <a href="{{ $url }}" style="padding: 10px 20px; background: #4F46E5; color: white; text-decoration: none;">
            Reset Password
        </a>
    </p>
    
    <p>Link ini akan kadaluarsa dalam 60 menit.</p>
    
    <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
    
    <p>Terima kasih,<br>{{ config('app.name') }}</p>
</body>
</html>
```

#### F. Update Login Page
Tambahkan link "Lupa Password" di **login.blade.php**:
```html
<div class="flex items-center justify-between">
    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
        Lupa Password?
    </a>
</div>
```

#### G. Config Email (jika belum)
**.env**
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@hospital.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Effort:** 3-4 jam  
**Testing:** 1 jam

---

### 2. 🔒 Remember Me (Stay Logged In)
**Kenapa Penting:**
- User tidak mau login terus-terusan
- Improve user experience
- Standard di semua aplikasi web

**Yang Harus Diubah:**

#### A. Update Login Controller
**AuthenticatedSessionController.php**
```php
public function store(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $remember = $request->boolean('remember'); // TAMBAH INI

    if (Auth::attempt($credentials, $remember)) { // TAMBAH $remember
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}
```

#### B. Update Login View
**login.blade.php**
```html
<!-- TAMBAH CHECKBOX INI -->
<div class="flex items-center">
    <input id="remember" name="remember" type="checkbox" 
           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
    <label for="remember" class="ml-2 block text-sm text-gray-900">
        Ingat Saya
    </label>
</div>
```

**Effort:** 30 menit

---

### 3. 👤 Profile Management
**Kenapa Penting:**
- User perlu update nama, email, phone
- User perlu ganti password sendiri
- Reduce admin workload

**Yang Harus Dibuat:**

#### A. Controller
**app/Http/Controllers/ProfileController.php**
```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if (!Hash::check($validated['current_password'], Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        return back()->with('success', 'Password berhasil diubah.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah.']);
        }

        Auth::logout();
        $user->delete();

        return redirect('/');
    }
}
```

#### B. Routes
**routes/web.php**
```php
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
```

#### C. View
**resources/views/profile/edit.blade.php**
```html
<x-app-layout>
    <div class="max-w-7xl mx-auto py-10">
        <h1 class="text-2xl font-bold mb-6">Profile Settings</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Update Profile Information -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-lg font-semibold mb-4">Profile Information</h2>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" 
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>

        <!-- Update Password -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-lg font-semibold mb-4">Update Password</h2>
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" 
                           name="current_password" required>
                    @error('current_password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" 
                           name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </div>

        <!-- Delete Account -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold mb-4 text-red-600">Delete Account</h2>
            <p class="mb-4">Setelah akun dihapus, semua data akan hilang permanen.</p>
            <form method="POST" action="{{ route('profile.destroy') }}" 
                  onsubmit="return confirm('Are you sure?')">
                @csrf
                @method('DELETE')

                <div class="mb-4">
                    <label for="password">Confirm with Password</label>
                    <input type="password" id="password" name="password" required>
                    @error('password')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-danger">Delete Account</button>
            </form>
        </div>
    </div>
</x-app-layout>
```

**Effort:** 2-3 jam

---

### 4. 🛡️ Login Attempt Limiting (Brute Force Protection)
**Kenapa Penting:**
- Protect dari hacker yang coba brute force password
- Security standard WAJIB

**Yang Harus Ditambahkan:**

#### Update Login Controller
**AuthenticatedSessionController.php**
```php
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

public function store(Request $request)
{
    // Rate limiting
    $this->ensureIsNotRateLimited($request);

    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $remember = $request->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {
        RateLimiter::clear($this->throttleKey($request)); // Clear on success
        $request->session()->regenerate();
        return redirect()->intended(route('dashboard'));
    }

    RateLimiter::hit($this->throttleKey($request)); // Hit on fail

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}

protected function ensureIsNotRateLimited(Request $request)
{
    if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
        return;
    }

    $seconds = RateLimiter::availableIn($this->throttleKey($request));

    throw ValidationException::withMessages([
        'email' => "Terlalu banyak percobaan login. Coba lagi dalam $seconds detik.",
    ]);
}

protected function throttleKey(Request $request)
{
    return Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
}
```

**Effort:** 1 jam

---

## 🟠 PRIORITAS 2 - PENTING (Week 2)

### 5. ✉️ Email Verification
**Kenapa Penting:**
- Pastikan email user valid
- Prevent fake account registration
- Standard untuk aplikasi modern

**Yang Harus Dibuat:**

#### A. Update User Model
```php
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    // ... existing code
}
```

#### B. Routes
```php
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
```

#### C. Middleware
Tambah `verified` middleware ke routes yang perlu verification:
```php
Route::get('/dashboard', function () {
    // ...
})->middleware(['auth', 'verified']);
```

**Effort:** 2 jam

---

### 6. 🔐 Two-Factor Authentication (2FA)
**Kenapa Penting:**
- Extra security untuk role sensitif (Admin, Doctor, Pharmacist)
- Protect dari account takeover
- Industry best practice

**Quick Implementation dengan Package:**
```bash
composer require pragmarx/google2fa-laravel
```

**Effort:** 4-6 jam (dengan package)

---

### 7. 🖥️ Session Management
**Kenapa Penting:**
- User bisa logout dari semua device
- Lihat active sessions
- Security feature

**Yang Harus Dibuat:**
- Tabel `sessions`
- View untuk lihat active sessions
- Button "Logout Other Devices"

**Effort:** 3-4 jam

---

## 📋 CHECKLIST IMPLEMENTASI

### Week 1 (WAJIB):
- [ ] Forgot Password & Reset Password (4 jam)
- [ ] Remember Me (30 menit)
- [ ] Profile Management (3 jam)
- [ ] Login Attempt Limiting (1 jam)

**Total Week 1:** ~8-9 jam kerja

### Week 2:
- [ ] Email Verification (2 jam)
- [ ] Two-Factor Authentication (6 jam)
- [ ] Session Management (4 jam)

**Total Week 2:** ~12 jam kerja

---

## 🎯 TESTING CHECKLIST

### Forgot Password:
- [ ] Klik "Lupa Password" → form muncul
- [ ] Input email tidak terdaftar → error message
- [ ] Input email valid → email terkirim
- [ ] Email berisi link reset yang valid
- [ ] Klik link → form reset password muncul
- [ ] Token invalid/expired → error message
- [ ] Input password baru → berhasil reset
- [ ] Login dengan password baru → berhasil

### Remember Me:
- [ ] Centang "Ingat Saya" → login
- [ ] Tutup browser, buka lagi → masih login
- [ ] Tidak centang → logout setelah tutup browser

### Profile:
- [ ] Update nama → tersimpan
- [ ] Update email → tersimpan
- [ ] Ganti password dengan current password salah → error
- [ ] Ganti password dengan current password benar → berhasil
- [ ] Login dengan password baru → berhasil

### Rate Limiting:
- [ ] Login salah 5x → blocked
- [ ] Tunggu 60 detik → bisa login lagi
- [ ] Login berhasil → counter reset

---

## 📧 EMAIL CONFIGURATION

Untuk testing di local, gunakan **Mailtrap** atau **Gmail**:

### Option 1: Mailtrap (Recommended untuk development)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
```

### Option 2: Gmail (Untuk production)
1. Enable 2FA di Gmail
2. Generate App Password di https://myaccount.google.com/apppasswords
3. Use App Password di .env:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-16-char-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourhospital.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🚀 LANGKAH IMPLEMENTASI

### Day 1 - Setup & Forgot Password
1. Buat migration `password_reset_tokens`
2. Buat controllers (PasswordResetLink, NewPassword)
3. Buat views (forgot-password, reset-password)
4. Setup email config
5. Testing

### Day 2 - Remember Me & Profile
1. Update login controller (remember me)
2. Update login view (checkbox)
3. Buat ProfileController
4. Buat profile views
5. Testing

### Day 3 - Security Features
1. Implement rate limiting
2. Email verification
3. Testing keseluruhan
4. Bug fixing

---

## 💡 TIPS

1. **Jangan skip email verification** - ini penting untuk prevent spam account
2. **Rate limiting WAJIB** - protect dari brute force
3. **Remember Me token** akan expired setelah 5 tahun (Laravel default)
4. **2FA** implementasi nanti kalau sudah stable, fokus basic dulu
5. **Testing email** pakai Mailtrap dulu, baru production pakai Gmail/SMTP

---

## ⚠️ KESALAHAN UMUM

### ❌ JANGAN:
- Simpan password plain text
- Kirim password via email
- Skip validasi password confirmation
- Hardcode email configuration
- Lupa test di production

### ✅ LAKUKAN:
- Always hash password
- Send reset LINK, not password
- Validate password minimum 8 karakter
- Use environment variables
- Test email delivery di production

---

**KESIMPULAN:**

Fokus dulu pada 4 fitur WAJIB di Week 1:
1. ✅ Forgot Password
2. ✅ Remember Me  
3. ✅ Profile Management
4. ✅ Rate Limiting

Total effort: **~9 jam kerja** untuk developer berpengalaman.

Setelah itu baru tambah Email Verification dan 2FA.

**Mau saya langsung implementasikan fitur-fitur ini sekarang?**
