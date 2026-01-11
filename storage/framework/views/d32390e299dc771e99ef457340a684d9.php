<nav class="bg-white/80 backdrop-blur-md fixed w-full z-50 transition-all duration-300 shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center gap-2">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <span class="font-bold text-2xl bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                        MedCare
                    </span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8">
                    <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600'); ?> font-medium px-3 py-2 rounded-md text-base transition-colors">Home</a>
                    <a href="<?php echo e(route('shop.index')); ?>" class="<?php echo e(request()->routeIs('shop.*') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600'); ?> font-medium px-3 py-2 rounded-md text-base transition-colors">Beli Obat</a>
                    <a href="<?php echo e(route('patient.appointments.book')); ?>" class="<?php echo e(request()->routeIs('patient.appointments.book') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600'); ?> font-medium px-3 py-2 rounded-md text-base transition-colors">Konsultasi</a>
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(Auth::user()->isPatient()): ?>
                            <a href="<?php echo e(route('patient.dashboard')); ?>" class="<?php echo e(request()->routeIs('patient.dashboard') ? 'text-indigo-600' : 'text-gray-600 hover:text-indigo-600'); ?> font-medium px-3 py-2 rounded-md text-base transition-colors">Dashboard</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:block">
                <div class="flex items-center gap-4">
                    <!-- Cart Button -->
                    <a href="<?php echo e(route('cart.index')); ?>" class="relative p-2 text-gray-600 hover:text-indigo-600 transition-colors group">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <?php if(isset($cartCount) && $cartCount > 0): ?>
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                                <?php echo e($cartCount); ?>

                            </span>
                        <?php endif; ?>
                    </a>
                    <?php if(auth()->guard()->check()): ?>
                        <!-- Profile Section with Dropdown -->
                        <div class="relative group">
                            <!-- Profile Button -->
                            <button class="flex items-center space-x-3 hover:opacity-80 transition-opacity cursor-pointer focus:outline-none">
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-gray-700"><?php echo e(Auth::user()->nama); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e(Auth::user()->email); ?></p>
                                </div>
                                <div class="w-11 h-11 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                    <?php echo e(strtoupper(substr(Auth::user()->nama, 0, 1))); ?>

                                </div>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-1 hidden group-hover:block z-50">
                                <div class="px-4 py-3 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-100">
                                    <p class="text-xs font-semibold text-indigo-500 uppercase tracking-wider">Akun</p>
                                </div>
                                <a href="<?php echo e(route('profile.edit')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors">
                                    Edit Profile
                                </a>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        Logout
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
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex md:hidden">
                <button type="button" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH E:\laragon\www\rumahsakit\resources\views/components/navbar.blade.php ENDPATH**/ ?>