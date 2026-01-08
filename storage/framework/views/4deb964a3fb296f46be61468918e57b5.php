<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli Obat - MedCare</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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
        .profile-dropdown-item:last-child { border-bottom: none; }
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
                <div class="flex-shrink-0 flex items-center gap-2">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-2xl bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">MedCare</span>
                    </a>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-8">
                        <a href="<?php echo e(route('home')); ?>" class="text-gray-600 hover:text-indigo-600 font-medium px-3 py-2 rounded-md text-base transition-colors">Home</a>
                        <a href="<?php echo e(route('shop.index')); ?>" class="text-indigo-600 font-semibold px-3 py-2 rounded-md text-base transition-colors">Beli Obat</a>
                        <a href="#" class="text-gray-600 hover:text-indigo-600 font-medium px-3 py-2 rounded-md text-base transition-colors">Konsultasi</a>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="flex items-center gap-4">
                        <?php if(auth()->guard()->check()): ?>
                            <div class="relative">
                                <button id="profileBtn" class="flex items-center space-x-3 hover:opacity-80 transition-opacity cursor-pointer focus:outline-none">
                                    <div class="text-right">
                                        <p class="text-sm font-semibold text-gray-700"><?php echo e(Auth::user()->nama); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo e(Auth::user()->email); ?></p>
                                    </div>
                                    <div class="w-11 h-11 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                        <?php echo e(strtoupper(substr(Auth::user()->nama, 0, 1))); ?>

                                    </div>
                                </button>
                                <div id="profileDropdown" class="profile-dropdown">
                                    <div class="px-4 py-3 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-200">
                                        <p class="text-xs font-medium text-gray-600 uppercase tracking-wide">Akun</p>
                                    </div>
                                    <a href="<?php echo e(route('profile.edit')); ?>" class="profile-dropdown-item">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span>Edit Profile</span>
                                    </a>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="profile-dropdown-item danger" style="padding: 0;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" style="display: flex; align-items: center; width: 100%; padding: 0.75rem 1rem; background: none; border: none; cursor: pointer; font-size: 0.875rem; color: inherit;">
                                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                            <span>Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="text-gray-600 hover:text-indigo-600 font-medium transition-colors">Sign In</a>
                            <a href="<?php echo e(route('register')); ?>" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2.5 rounded-full font-medium hover:shadow-lg hover:scale-105 transition-all duration-300 shadow-indigo-200">
                                Sign Up
                            </a>
                        <?php endif; ?>
                        
                        <!-- Cart Icon -->
                        <div class="relative cursor-pointer group">
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white">0</span>
                            <div class="p-2 rounded-full hover:bg-gray-100 transition-colors">
                                <svg class="w-6 h-6 text-gray-600 group-hover:text-indigo-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Clean Hero Banner -->
    <div class="pt-32 pb-16 bg-gradient-to-br from-indigo-900 via-purple-900 to-slate-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-white/5 to-transparent skew-x-12"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-indigo-500/30 border border-indigo-400/30 text-indigo-300 text-sm font-semibold mb-6 backdrop-blur-sm">
                Pharmacy Services
            </span>
            <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight tracking-tight">
                Health & Wellness <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-purple-400">Delivered to You</span>
            </h1>
            <p class="text-lg text-gray-300 mb-10 max-w-2xl mx-auto">
                Find trusted medicines, health supplements, and personal care products. Genuine quality, better health.
            </p>
            
            <!-- Search Bar -->
            <div class="max-w-xl mx-auto relative group">
                <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-2xl blur opacity-25 group-hover:opacity-75 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative bg-white rounded-2xl shadow-xl flex items-center p-2">
                    <svg class="w-6 h-6 text-gray-400 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" placeholder="Search for medicines..." class="w-full px-4 py-3 outline-none text-gray-700 placeholder-gray-400 bg-transparent">
                    <button class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-indigo-700 transition shadow-md">Search</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Filter (Clean Version) -->
    <div class="bg-white border-b border-gray-100 sticky top-20 z-40 shadow-sm/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between py-4 overflow-x-auto no-scrollbar gap-4">
                <a href="<?php echo e(route('shop.index')); ?>" class="flex items-center px-4 py-2 rounded-full whitespace-nowrap transition-all duration-200 <?php echo e(!request('category') ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'); ?>">
                    <span class="font-medium text-sm">All Products</span>
                </a>

                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('shop.index', ['category' => $cat])); ?>" class="flex items-center space-x-2 px-4 py-2 rounded-full whitespace-nowrap transition-all duration-200 <?php echo e(request('category') == $cat ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100'); ?>">
                    <span class="font-medium text-sm"><?php echo e($cat); ?></span>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 bg-gray-50/50 min-h-screen">
        <div class="flex justify-between items-end mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Featured Medicines</h2>
                <p class="text-gray-500 text-sm mt-1">Browse our collection of high quality products</p>
            </div>
            <!-- Sort dropdown could go here -->
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            <?php $__currentLoopData = $medications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $med): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 group overflow-hidden border border-gray-100 flex flex-col h-full">
                <!-- Image Area -->
                <div class="bg-gray-50 h-56 flex items-center justify-center p-8 relative overflow-hidden">
                    <!-- Placeholder Icon -->
                    <div class="w-32 h-32 bg-indigo-50 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-16 h-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Content Area -->
                <div class="p-6 flex-1 flex flex-col">
                    <div class="mb-auto">
                        <span class="inline-block px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-600 text-xs font-semibold mb-3 tracking-wide uppercase">
                            <?php echo e($med->kategori); ?>

                        </span>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 leading-snug group-hover:text-indigo-600 transition-colors">
                            <?php echo e($med->nama); ?>

                        </h3>
                        <p class="text-gray-500 text-sm line-clamp-2 mb-4">
                            Premium quality medication for your health needs. Ensure to consult a doctor before use.
                        </p>
                    </div>
                    
                    <div class="border-t border-gray-100 pt-4 mt-2 flex items-center justify-between">
                        <span class="text-2xl font-bold text-gray-900">
                            <span class="text-sm font-medium text-gray-400 align-top mr-0.5">Rp</span><?php echo e(number_format($med->harga, 0, ',', '.')); ?>

                        </span>
                        <button class="w-10 h-10 rounded-full bg-gray-50 text-gray-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-all shadow-sm hover:shadow-indigo-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-16">
            <?php echo e($medications->withQueryString()->links()); ?>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center text-white text-xs">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <span class="font-bold text-xl text-gray-800">MedCare</span>
                </div>
                 <p class="text-gray-500 text-sm">© 2024 MedCare Hospital System. All rights reserved.</p>
                 <div class="flex gap-4">
                     <a href="#" class="text-gray-400 hover:text-indigo-600 transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></a>
                     <a href="#" class="text-gray-400 hover:text-pink-600 transition"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                 </div>
            </div>
        </div>
    </footer>

    <script>
        // Profile Dropdown Functionality
        <?php if(auth()->guard()->check()): ?>
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
        <?php endif; ?>
    </script>
</body>
</html>
<?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views/shop/index.blade.php ENDPATH**/ ?>