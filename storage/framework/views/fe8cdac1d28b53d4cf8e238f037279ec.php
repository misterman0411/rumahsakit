<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-linear-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-16">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="flex justify-center mb-6">
                    <div class="bg-blue-600 rounded-full p-6">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
                <h1 class="text-5xl font-bold text-gray-800 mb-4">Hospital Management System</h1>
                <p class="text-xl text-gray-600">Sistem Manajemen Rumah Sakit Terpadu</p>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-lg shadow-xl p-8 text-center">
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-200 shadow-lg hover:shadow-xl">
                            <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-10 rounded-lg transition duration-200 shadow-lg hover:shadow-xl">
                            <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Login Sistem
                        </a>
                    <?php endif; ?>
                </div>
                <p class="text-sm text-gray-500 mt-4">Sistem Internal - Hanya untuk Staff Rumah Sakit</p>
            </div>

            <!-- Footer -->
            <div class="text-center mt-12 text-gray-600">
                <p>&copy; <?php echo e(date('Y')); ?> Hospital Management System. All rights reserved.</p>
                <p class="mt-2 text-sm">Laravel v<?php echo e(Illuminate\Foundation\Application::VERSION); ?> (PHP v<?php echo e(PHP_VERSION); ?>)</p>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH E:\laragon\www\rumahsakit\resources\views/welcome.blade.php ENDPATH**/ ?>