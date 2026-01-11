<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Other Devices - Hospital Management System</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Logout Other Devices
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.
                </p>
            </div>

            <?php if(session('status')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?php echo e(session('status')); ?></span>
                </div>
            <?php endif; ?>

            <form class="mt-8 space-y-6" action="<?php echo e(route('logout.other-devices')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" required 
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm" 
                            placeholder="Password">
                    </div>
                </div>

                <?php if($errors->any()): ?>
                    <div class="text-red-500 text-sm">
                        <?php echo e($errors->first()); ?>

                    </div>
                <?php endif; ?>

                <div class="flex items-center justify-between">
                    <a href="<?php echo e(route('dashboard')); ?>" class="text-sm text-blue-600 hover:text-blue-500">
                        Back to Dashboard
                    </a>
                    <button type="submit" 
                        class="group relative flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Logout Other Devices
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\auth\confirm-logout-other-devices.blade.php ENDPATH**/ ?>