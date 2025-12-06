@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="space-y-6">
    <!-- Profile Header Card -->
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
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
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
                            <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Lengkap
                            </label>
                            <div class="relative">
                                <input type="text" id="nama" name="nama" 
                                       value="{{ old('nama', $user->nama) }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition {{ $errors->has('nama') ? 'border-red-500 focus:ring-red-500' : '' }}"
                                       placeholder="Masukkan nama lengkap">
                                <svg class="w-5 h-5 text-gray-400 absolute right-3 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            @error('nama')
                                <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 16.586 5.314 11.9a1 1 0 00-1.414 1.414l5.5 5.5a1 1 0 001.414 0l8.587-8.587z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address
                            </label>
                            <div class="relative">
                                <input type="email" id="email" name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition {{ $errors->has('email') ? 'border-red-500 focus:ring-red-500' : '' }}"
                                       placeholder="Masukkan email">
                                <svg class="w-5 h-5 text-gray-400 absolute right-3 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @error('email')
                                <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 16.586 5.314 11.9a1 1 0 00-1.414 1.414l5.5 5.5a1 1 0 001.414 0l8.587-8.587z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" 
                                    class="flex items-center space-x-2 bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Simpan Perubahan</span>
                            </button>
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center space-x-2 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Batal</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change Password Section -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow" id="change-password">
                <div class="px-6 py-4 bg-gradient-to-r from-orange-50 to-amber-50 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
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
                            <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password Saat Ini
                            </label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition {{ $errors->has('current_password') ? 'border-red-500 focus:ring-red-500' : '' }}"
                                       placeholder="Masukkan password saat ini">
                                <svg class="w-5 h-5 text-gray-400 absolute right-3 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            @error('current_password')
                                <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 16.586 5.314 11.9a1 1 0 00-1.414 1.414l5.5 5.5a1 1 0 001.414 0l8.587-8.587z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition {{ $errors->has('password') ? 'border-red-500 focus:ring-red-500' : '' }}"
                                       placeholder="Masukkan password baru (minimal 8 karakter)">
                                <svg class="w-5 h-5 text-gray-400 absolute right-3 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-600 text-xs mt-2">Password harus minimal 8 karakter dengan kombinasi huruf besar, kecil, angka, dan simbol.</p>
                            @error('password')
                                <p class="text-red-500 text-sm mt-2 flex items-center space-x-1">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18.101 12.93a1 1 0 00-1.414-1.414L10 16.586 5.314 11.9a1 1 0 00-1.414 1.414l5.5 5.5a1 1 0 001.414 0l8.587-8.587z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Konfirmasi Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition"
                                       placeholder="Konfirmasi password baru">
                                <svg class="w-5 h-5 text-gray-400 absolute right-3 top-3.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button type="submit" 
                                    class="flex items-center space-x-2 bg-orange-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-orange-700 transition-colors shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <span>Ubah Password</span>
                            </button>
                            <a href="{{ route('dashboard') }}" 
                               class="flex items-center space-x-2 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <span>Batal</span>
                            </a>
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
                    <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
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

                    <div class="h-px bg-gray-200"></div>

                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Terakhir Update</p>
                        <p class="text-gray-900 font-semibold mt-1">{{ $user->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Security Tips -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl shadow-md p-6 mt-6">
                <h4 class="text-sm font-bold text-blue-900 mb-3 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span>💡 Keamanan</span>
                </h4>
                <ul class="text-xs text-blue-800 space-y-2">
                    <li class="flex space-x-2">
                        <span class="text-blue-600 font-bold">•</span>
                        <span>Gunakan password yang kuat dan unik</span>
                    </li>
                    <li class="flex space-x-2">
                        <span class="text-blue-600 font-bold">•</span>
                        <span>Jangan bagikan password Anda</span>
                    </li>
                    <li class="flex space-x-2">
                        <span class="text-blue-600 font-bold">•</span>
                        <span>Update password secara berkala</span>
                    </li>
                    <li class="flex space-x-2">
                        <span class="text-blue-600 font-bold">•</span>
                        <span>Logout setelah selesai</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection