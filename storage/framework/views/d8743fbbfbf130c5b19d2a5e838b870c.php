<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden max-w-5xl w-full flex flex-col md:flex-row min-h-[600px]">

        <!-- Left Side -->
        <div class="w-full md:w-1/2 bg-blue-600 p-12 text-white flex flex-col justify-between relative overflow-hidden">
            
            <div class="relative z-10">
                <div class="flex items-center gap-0.5 mb-8">
                    <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center text-blue-700 font-bold">M</div>
                    <span class="font-bold text-xl">EDICARE</span>
                </div>

                <div class="my-12 flex justify-center">
                    <div class="w-64 h-64 bg-blue-500 rounded-full flex items-center justify-center opacity-80">
                        <svg class="w-32 h-32 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div>
                    <h2 class="text-3xl font-bold mb-2">Welcome!</h2>
                    <p class="text-blue-100">Mari Menjaga Kesehatan dan Berkonsultasi Ke Dokter Bersama Medicare.</p>
                    <div class="flex gap-2 mt-4">
                        <div class="w-2 h-2 rounded-full bg-white"></div>
                        <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                        <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                    </div>
                </div>
            </div>

            <!-- Decorative Circles -->
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-blue-500 opacity-20"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 rounded-full bg-blue-500 opacity-20"></div>

        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full md:w-1/2 p-12 flex flex-col justify-center">
            <div class="max-w-md mx-auto w-full">
                <h2 class="text-3xl font-bold text-gray-900 mb-2">Log In</h2>

                <p class="text-gray-500 mb-8 text-sm">
                    Don't have an account?
                    <a href="<?php echo e(route('register')); ?>" class="text-blue-600 font-medium hover:underline">Create an account</a><br>
                    It will take less than a minute.
                </p>

                <!-- Locked Message (Countdown Timer) -->
                <?php if(!empty($attemptInfo) && $attemptInfo['is_locked'] && $attemptInfo['locked_until']): ?>
                    <div id="lockMessageContainer" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-red-700 text-sm font-medium">Akun Terkunci</p>
                        </div>
                        <p class="text-red-600 text-sm">
                            Terlalu banyak percobaan login. Silakan coba lagi dalam <span id="lockTimer" class="font-bold text-red-700">0:00</span>
                        </p>
                    </div>
                <!-- Attempt Counter Warning -->
                <?php elseif($errors->any() && !empty($attemptInfo) && $attemptInfo['attempts'] > 0 && !$attemptInfo['is_locked']): ?> 
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <p class="text-yellow-800 text-sm font-medium">Login gagal!</p>
                        </div>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <p class="text-yellow-700 text-sm">• salah input email atau password</p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <p class="text-yellow-700 text-sm">
                            <strong class="text-red-600"><?php echo e($attemptInfo['remaining']); ?></strong> percobaan tersisa sebelum akun terkunci.
                        </p>
                    </div>
                <?php elseif($errors->any()): ?>
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-red-700 text-sm font-medium">Login gagal!</p>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p class="text-red-600 text-sm">• <?php echo e($error); ?></p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('login')); ?>" id="loginForm">
                    <?php echo csrf_field(); ?>

                    <!-- Email -->
                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email
                        </label>

                        <div class="relative">
                            <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required
                                   class="w-full px-4 py-3 border-b focus:outline-none transition bg-transparent placeholder-gray-400 <?php echo e($errors->has('email') ? 'border-red-500 focus:border-red-600' : 'border-gray-300 focus:border-blue-600'); ?>"
                                   placeholder="Enter your email">

                            <div class="absolute right-0 top-3 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password
                        </label>

                        <div class="relative">
                            <input id="password" type="password" name="password" required
                                   class="w-full px-4 py-3 border-b focus:outline-none transition bg-transparent placeholder-gray-400 <?php echo e($errors->has('password') ? 'border-red-500 focus:border-red-600' : 'border-gray-300 focus:border-blue-600'); ?>"
                                   placeholder="Enter your password">
                            <div class="absolute right-0 top-3 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                        </div>
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Remember & Submit -->
                    <div class="flex items-center justify-between mb-8">
                        <button type="submit"
                                class="bg-blue-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                            Sign in
                        </button>

                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">

                            <label for="remember" class="ml-2 block text-sm text-gray-500">
                                Remember password
                            </label>
                        </div>
                    </div>

                    <div class="text-right">
                        <a href="#" class="text-sm text-blue-600 hover:underline">
                            Forget your password?
                        </a>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

<script>
    // Countdown Timer untuk Lock Message
    <?php if(!empty($attemptInfo) && $attemptInfo['is_locked'] && $attemptInfo['locked_until']): ?>
        const lockedUntil = new Date('<?php echo e($attemptInfo['locked_until']); ?>').getTime();
        const lockTimerElement = document.getElementById('lockTimer');
        const lockMessageContainer = document.getElementById('lockMessageContainer');
        const submitBtn = document.getElementById('submitBtn');
        const loginForm = document.getElementById('loginForm');

        function updateCountdown() {
            const now = new Date().getTime();
            const timeLeft = lockedUntil - now;

            if (timeLeft <= 0) {
                // Waktu sudah habis, sembunyikan message dan enable button
                lockMessageContainer.style.display = 'none';
                submitBtn.disabled = false;
                clearInterval(countdownInterval);
                return;
            }

            const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

            lockTimerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        }

        // Update immediately dan setiap 1 detik
        updateCountdown();
        const countdownInterval = setInterval(updateCountdown, 1000);
    <?php endif; ?>
</script>

</body>
</html>
<?php /**PATH E:\laragon\www\rumahsakit\resources\views/auth/login.blade.php ENDPATH**/ ?>