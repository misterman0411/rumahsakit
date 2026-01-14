<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Hospital Management System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        
        /* Profile Dropdown Styles */
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
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .profile-dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            text-decoration: none;
            color: #374151;
            font-size: 0.875rem;
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s;
        }
        
        .profile-dropdown-item:last-child {
            border-bottom: none;
        }
        
        .profile-dropdown-item:hover {
            background-color: #f9fafb;
            color: #6366f1;
        }
        
        .profile-dropdown-item.danger:hover {
            background-color: #fef2f2;
            color: #dc2626;
        }
        
        .profile-dropdown-item svg {
            width: 1rem;
            height: 1rem;
            margin-right: 0.75rem;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">
    <!-- Navbar -->
    <x-navbar />
    
    <!-- Hero Section -->
    <div class="relative pt-20 pb-16 md:pt-32 md:pb-24 overflow-hidden bg-gradient-to-br from-indigo-50 via-purple-50 to-white">
        <!-- Decoration blobs -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
             <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
             <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
             <div class="absolute bottom-[-20%] left-[20%] w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="text-left">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-indigo-100/50 text-indigo-700 font-semibold text-sm mb-6 border border-indigo-200 backdrop-blur-sm">
                        <span class="flex h-2 w-2 relative mr-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        #1 Health Care Solution
                    </div>
                    <h1 class="text-5xl md:text-6xl font-bold text-gray-900 leading-tight mb-6">
                        Online <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Doctor</span> <br>
                        Consultation
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-lg">
                        Dapatkan layanan kesehatan terbaik dari dokter spesialis berpengalaman. Konsultasi online, beli obat, dan buat janji temu dengan mudah dan cepat.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('patient.appointments.book') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-8 py-3 rounded-full font-medium hover:shadow-lg hover:scale-105 transition-all duration-300 shadow-indigo-200">
                            Konsultasi Sekarang
                        </a>
                    </div>
                </div>
                
                <!-- Hero Image Area -->
                <div class="relative">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white transform hover:scale-[1.02] transition-transform duration-500 group">
                        <!-- Abstract Medical Illustration Placeholder -->
                        <div class="bg-indigo-100 aspect-[4/3] flex items-center justify-center relative overflow-hidden">
                             <!-- Doctor SVG Illustration -->
                             <svg class="w-full h-full absolute inset-0 text-indigo-200 opacity-20" fill="currentColor" viewBox="0 0 24 24">
                                 <path d="M12 4a4 4 0 110 8 4 4 0 010-8zM6 20a6 6 0 0112 0v1H6v-1z" opacity="0.3"/>
                             </svg>
                             <!-- Doctor Image Fallback (User should upload real image) -->
                             <img src="https://img.freepik.com/free-photo/portrait-smiling-handsome-male-doctor-man_171337-5055.jpg" alt="Doctor" class="object-cover w-full h-full opacity-90 group-hover:scale-110 transition-transform duration-700">
                        </div>
                        
                        <!-- Floating Card -->
                        <div class="absolute bottom-6 left-6 bg-white/90 backdrop-blur-md p-4 rounded-xl shadow-lg border border-white/50 animate-bounce delay-700">
                             <div class="flex items-center gap-3">
                                 <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                     <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                     </svg>
                                 </div>
                                 <div>
                                     <p class="text-sm font-bold text-gray-800">Verified Doctors</p>
                                     <p class="text-xs text-gray-500">Highly Qualified</p>
                                 </div>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-indigo-600 font-semibold tracking-wide uppercase text-sm">Our Services</span>
                <h2 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    Layanan Kesehatan Terpadu
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">
                    Kami menyediakan berbagai layanan kesehatan untuk memenuhi kebutuhan Anda dan keluarga.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600 mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                         <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                         </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Konsultasi Dokter</h3>
                    <p class="text-gray-500 mb-6">Konsultasi dengan dokter umum dan spesialis secara online melalui video call atau chat.</p>
                    <a href="{{ route('patient.appointments.book') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 flex items-center group-hover:gap-2 transition-all">
                        Learn more <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <!-- Service 2 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 mb-6 group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Apotek & Obat</h3>
                    <p class="text-gray-500 mb-6">Beli obat resep dan perlengkapan kesehatan dengan mudah, diantar langsung ke rumah Anda.</p>
                    <a href="{{ route('shop.index') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 flex items-center group-hover:gap-2 transition-all">
                        Learn more <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                <!-- Service 3 -->
                <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-xl border border-gray-100 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Buat Janji Temu</h3>
                    <p class="text-gray-500 mb-6">Jadwalkan kunjungan ke rumah sakit atau klinik kami tanpa perlu antri lama.</p>
                    <a href="{{ route('patient.appointments.book') }}" class="text-indigo-600 font-semibold hover:text-indigo-700 flex items-center group-hover:gap-2 transition-all">
                        Learn more <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="relative bg-gray-900 py-16">
        <div class="absolute inset-0 overflow-hidden">
             <!-- Background pattern/image -->
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-800 to-purple-800 opacity-90"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">
            <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                Siap untuk hidup lebih sehat?
            </h2>
            <p class="mt-4 text-xl text-indigo-100 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan pengguna lainnya yang telah mempercayakan kesehatan mereka pada MedCare.
            </p>
            <div class="mt-8 flex justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-3 border border-transparent text-base font-semibold rounded-full text-indigo-600 bg-white hover:bg-gray-50 md:text-lg shadow-md transition-all">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-1">
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center text-white text-xs">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-gray-800">MedCare</span>
                    </div>
                    <p class="text-gray-500 text-sm">
                        Layanan kesehatan terpercaya untuk Anda dan keluarga. Cepat, mudah, dan profesional.
                    </p>
                </div>
                
                <!-- Links -->
                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Layanan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-500 hover:text-indigo-600 text-sm">Konsultasi Dokter</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-indigo-600 text-sm">Beli Obat</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-indigo-600 text-sm">Janji Temu</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-indigo-600 text-sm">Lab Test</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Perusahaan</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-500 hover:text-indigo-600 text-sm">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-indigo-600 text-sm">Hubungi Kami</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-indigo-600 text-sm">Karir</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-indigo-600 text-sm">Blog</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Legal</h3>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-500 hover:text-indigo-600 text-sm">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-indigo-600 text-sm">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-gray-200 pt-8 text-center">
                <p class="text-gray-400 text-sm">© 2024 MedCare Hospital System. All rights reserved.</p>
            </div>
        </div>
    </footer>

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
