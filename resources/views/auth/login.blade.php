<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - MedCare</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>

<body class="bg-gray-50">

<div class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-5xl w-full flex flex-col md:flex-row min-h-[600px] border border-gray-100">

        <!-- Left Side - Branding -->
        <div class="w-full md:w-1/2 bg-gradient-to-br from-indigo-600 to-purple-700 p-12 text-white flex flex-col justify-between relative overflow-hidden">
            
            <div class="relative z-10">
                <div class="flex items-center gap-2 mb-8">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-md rounded-xl flex items-center justify-center text-white font-bold shadow-lg border border-white/30">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-2xl tracking-wide">MedCare</span>
                </div>

                <div class="my-12 flex justify-center relative">
                    <!-- Glowing effect -->
                    <div class="absolute inset-0 bg-white/30 filter blur-3xl opacity-30 rounded-full animate-pulse"></div>
                    
                    <div class="w-64 h-64 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center border border-white/20 shadow-2xl relative z-10">
                        <svg class="w-32 h-32 text-indigo-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div>
                    <h2 class="text-3xl font-bold mb-3">Welcome Back!</h2>
                    <p class="text-indigo-100 text-lg">Akses layanan kesehatan digital terbaik untuk Anda dan keluarga.</p>
                    <div class="flex gap-2 mt-6">
                        <div class="w-2 h-2 rounded-full bg-white animate-bounce"></div>
                        <div class="w-2 h-2 rounded-full bg-indigo-300 animate-bounce delay-100"></div>
                        <div class="w-2 h-2 rounded-full bg-indigo-300 animate-bounce delay-200"></div>
                    </div>
                </div>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-purple-500 mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 rounded-full bg-indigo-500 mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            
            <!-- Pattern -->
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center bg-white relative">
            <div class="max-w-md mx-auto w-full">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign In</h2>
                    <p class="text-gray-500 text-sm">Masuk untuk mengakses dashboard MedCare.</p>
                </div>

                <!-- Registration Prompt -->
                <p class="text-gray-500 mb-8 text-sm bg-gray-50 p-4 rounded-xl border border-gray-100">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:text-indigo-700 transition-colors">Daftar sekarang</a>
                    <span class="block text-xs mt-1">Hanya butuh waktu kurang dari 1 menit.</span>
                </p>

                <!-- Alerts Logic -->
                @if(!empty($attemptInfo) && $attemptInfo['is_locked'] && $attemptInfo['locked_until'])
                    <div id="lockMessageContainer" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3">
                        <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                        <div>
                            <h3 class="text-red-800 font-semibold text-sm">Akun Terkunci</h3>
                            <p class="text-red-600 text-sm mt-1">
                                Silakan coba lagi dalam <span id="lockTimer" class="font-bold font-mono bg-red-100 px-2 py-0.5 rounded">0:00</span>
                            </p>
                        </div>
                    </div>
                @elseif ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                        <div class="flex items-center gap-2 mb-1">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <h3 class="text-red-800 font-semibold text-sm">Login Gagal</h3>
                        </div>
                        <ul class="list-disc list-inside text-red-600 text-sm ml-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- Email -->
                    <div class="mb-6 group">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <div class="relative transition-all duration-300">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all bg-gray-50 focus:bg-white placeholder-gray-400 text-gray-800"
                                   placeholder="nama@email.com">
                            <div class="absolute left-0 top-0 h-full w-11 flex items-center justify-center text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-6 group">
                        <div class="flex justify-between items-center mb-2">
                             <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                             @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <div class="relative transition-all duration-300">
                            <input id="password" type="password" name="password" required
                                   class="w-full pl-11 pr-4 py-3.5 border border-gray-200 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all bg-gray-50 focus:bg-white placeholder-gray-400 text-gray-800"
                                   placeholder="••••••••">
                            <div class="absolute left-0 top-0 h-full w-11 flex items-center justify-center text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Remember & Submit -->
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember"
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer">
                            <label for="remember" class="ml-2 block text-sm text-gray-600 cursor-pointer select-none">
                                Ingat saya
                            </label>
                        </div>

                        <button type="submit" id="submitBtn"
                                class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-4 px-8 rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 shadow-lg shadow-indigo-200 transform transition-all hover:scale-[1.02] active:scale-[0.98]">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@if(!empty($attemptInfo) && $attemptInfo['is_locked'] && $attemptInfo['locked_until'])
@php
    $lockedUntilTime = $attemptInfo['locked_until'];
@endphp
<script>
    (function() {
        const lockedUntil = new Date('{{ $lockedUntilTime }}').getTime();
        const lockTimerElement = document.getElementById('lockTimer');
        const lockMessageContainer = document.getElementById('lockMessageContainer');
        const submitBtn = document.getElementById('submitBtn');
        const loginForm = document.getElementById('loginForm');

        function updateCountdown() {
            const now = new Date().getTime();
            const timeLeft = lockedUntil - now;

            if (timeLeft <= 0) {
                if(lockMessageContainer) lockMessageContainer.style.display = 'none';
                if(submitBtn) submitBtn.disabled = false;
                if(submitBtn) submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                clearInterval(countdownInterval);
                return;
            } else {
                 if(submitBtn) {
                     submitBtn.disabled = true;
                     submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                 }
            }

            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            if(lockTimerElement) lockTimerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }

        updateCountdown();
        const countdownInterval = setInterval(updateCountdown, 1000);
    })();
</script>
@endif

</body>
</html>
