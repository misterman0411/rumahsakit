

<?php $__env->startSection('title', 'Doctors'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-gray-800">Doctors</h2>
        <a href="<?php echo e(route('doctors.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
            Add Doctor
        </a>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-900"><?php echo e($doctor->user->nama); ?></h3>
                <p class="text-sm text-gray-600"><?php echo e($doctor->spesialisasi); ?></p>
                <p class="text-sm text-gray-500 mt-2"><?php echo e($doctor->departemen->nama); ?></p>
                <p class="text-sm text-gray-500">License: <?php echo e($doctor->nomor_lisensi); ?></p>
                <div class="mt-4 flex space-x-2">
                    <a href="<?php echo e(route('doctors.show', $doctor)); ?>" class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                    <a href="<?php echo e(route('doctors.edit', $doctor)); ?>" class="text-green-600 hover:text-green-900 text-sm">Edit</a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="col-span-3 text-center text-gray-500">No doctors found</p>
            <?php endif; ?>
        </div>

        <div class="mt-4">
            <?php echo e($doctors->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rs\hospital-management-system\resources\views/doctors/index.blade.php ENDPATH**/ ?>