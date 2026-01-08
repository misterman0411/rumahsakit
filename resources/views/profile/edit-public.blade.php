<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - MedCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .profile-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 50;
            min-width: 240px;
            margin-top: 0.5rem;
        }
        .profile-dropdown.active {
            display: block;
            animation: slideDown 0.2s ease-out;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .profile-dropdown-item {
            display: flex; align-items: center; padding: 0.75rem 1rem;
            text-decoration: none; color: #374151; font-size: 0.875rem;
            border-bottom: 1px solid #f3f4f6; transition: background-color 0.2s;
        }
        .profile-dropdown-item:hover { background-color: #f9fafb; color: #6366f1; }
        .profile-dropdown-item.danger:hover { background-color: #fef2f2; color: #dc2626; }
        .profile-dropdown-item svg { width: 1rem; height: 1rem; margin-right: 0.75rem; }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md fixed w-full z-50 transition-all duration-300 shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-2xl bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">MedCare</span>
                    </a>
                </div>
                <!-- Links -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-indigo-600 font-medium px-3 py-2 rounded-md text-base transition-colors">Home</a>
                        <a href="{{ route('shop.index') }}" class="text-gray-600 hover:text-indigo-600 font-medium px-3 py-2 rounded-md text-base transition-colors">Beli Obat</a>
                        <a href="#" class="text-gray-600 hover:text-indigo-600 font-medium px-3 py-2 rounded-md text-base transition-colors">Konsultasi</a>
                    </div>
                </div>
                <!-- Auth -->
                <div class="hidden md:block">
                    <div class="flex items-center gap-4">
                        @auth
                            <div class="relative">
                                <button id="profileBtn" class="flex items-center space-x-3 hover:opacity-80 transition-opacity cursor-pointer focus:outline-none">
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->nama }}</p>
                                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                    </div>
                                    <div class="w-11 h-11 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                                    </div>
                                </button>
                                <div id="profileDropdown" class="profile-dropdown">
                                    <div class="px-4 py-3 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-200">
                                        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Akun</p>
                                    </div>
                                    <a href="{{ route('profile.edit') }}" class="profile-dropdown-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span>Edit Profile</span>
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="profile-dropdown-item danger" style="padding: 0;">
                                        @csrf
                                        <button type="submit" style="display: flex; align-items: center; width: 100%; padding: 0.75rem 1rem; background: none; border: none; cursor: pointer; font-size: 0.875rem; color: inherit;">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition-colors">Sign In</a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2.5 rounded-full font-medium shadow-indigo-200 hover:shadow-lg">Sign Up</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Content (Styled EXACTLY like Staff Profile) -->
    <div class="pt-24 pb-12 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-r-lg shadow-sm flex items-center space-x-3">
                <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="space-y-6">
            <!-- Profile Header Card (Same as Staff) -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-lg overflow-hidden">
                <div class="px-8 py-8 text-white flex items-center space-x-6">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center text-4xl font-bold">
                        {{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">{{ Auth::user()->nama }}</h1>
                        <p class="text-indigo-100 mt-1">{{ Auth::user()->email }}</p>
                        <div class="flex items-center space-x-2 mt-2">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium">
                                {{ ucfirst(Auth::user()->role->nama ?? 'User') }}
                            </span>
                            <span class="text-indigo-100 text-sm">•</span>
                            <span class="text-indigo-100 text-sm">Terdaftar sejak {{ Auth::user()->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Update Profile Information -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-gray-900">Informasi Profil</h2>
                                    <p class="text-sm text-gray-600">Update nama dan email Anda</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 space-y-5">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PATCH')

                                <!-- Nama -->
                                <div>
                                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                    <div class="relative">
                                        <input type="text" id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition {{ $errors->has('nama') ? 'border-red-500 focus:ring-red-500' : '' }}" placeholder="Masukkan nama lengkap">
                                        <svg class="w-5 h-5 text-gray-400 absolute right-3 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                                    <div class="relative">
                                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500' : '' }}" placeholder="Masukkan email">
                                        <svg class="w-5 h-5 text-gray-400 absolute right-3 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="flex gap-3 pt-4">
                                    <button type="submit" class="flex items-center space-x-2 bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span>Simpan Perubahan</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Change Password Section -->
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow" id="change-password">
                        <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-gray-200">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center text-white">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                                <div>
                                    <h2 class="text-lg font-bold text-gray-900">Ubah Password</h2>
                                    <p class="text-sm text-gray-600">Perbarui password akun Anda untuk keamanan lebih baik</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 space-y-5">
                            <form method="POST" action="{{ route('profile.password') }}">
                                @csrf
                                @method('PUT')

                                <!-- Current Password -->
                                <div>
                                    <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">Password Saat Ini</label>
                                    <div class="relative">
                                        <input type="password" id="current_password" name="current_password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition" placeholder="Masukkan password saat ini">
                                    </div>
                                </div>

                                <!-- New Password -->
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                                    <div class="relative">
                                        <input type="password" id="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition" placeholder="Masukkan password baru (minimal 8 karakter)">
                                    </div>
                                    <p class="text-gray-600 text-xs mt-2">Password harus minimal 8 karakter dengan kombinasi huruf besar, kecil, angka, dan simbol.</p>
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                    <div class="relative">
                                        <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition" placeholder="Konfirmasi password baru">
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="flex gap-3 pt-4">
                                    <button type="submit" class="flex items-center space-x-2 bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-700 transition-colors shadow-md hover:shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                                        <span>Ubah Password</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Info Card -->
                <div class="lg:col-span-1">
                    <!-- Account Info -->
                    <div class="bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center space-x-2">
                            <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                            <span>Informasi Akun</span>
                        </h3>

                        <div class="space-y-4">
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</p>
                                <p class="text-gray-900 font-semibold mt-1">{{ $user->nama }}</p>
                            </div>
                            <div class="h-px bg-gray-200"></div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</p>
                                <p class="text-gray-900 font-semibold mt-1 break-all">{{ $user->email }}</p>
                            </div>
                            <div class="h-px bg-gray-200"></div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Posisi</p>
                                <span class="inline-block mt-1 px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-semibold">
                                    {{ ucfirst($user->role->nama ?? 'User') }}
                                </span>
                            </div>
                             <div class="h-px bg-gray-200"></div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Terdaftar Sejak</p>
                                <p class="text-gray-900 font-semibold mt-1">{{ $user->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Profile Dropdown Functionality
        @auth
            const profileBtn = document.getElementById('profileBtn');
            const profileDropdown = document.getElementById('profileDropdown');

            if (profileBtn && profileDropdown) {
                profileBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    profileDropdown.classList.toggle('active');
                });
                document.addEventListener('click', function(e) {
                    if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                        profileDropdown.classList.remove('active');
                    }
                });
            }
        @endauth
    </script>
</body>
</html>
