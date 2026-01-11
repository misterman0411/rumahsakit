<?php $__env->startSection('title', 'Appointment Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-gray-800">Appointment Details</h2>
        <div class="space-x-2">
            <?php if($appointment->status == 'scheduled'): ?>
            <form action="<?php echo e(route('appointments.check-in', $appointment)); ?>" method="POST" class="inline">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                    Check In
                </button>
            </form>
            <?php endif; ?>
            <a href="<?php echo e(route('appointments.edit', $appointment)); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Edit
            </a>
        </div>
    </div>

    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="text-sm font-medium text-gray-500">Appointment Number</label>
            <p class="mt-1 text-lg text-gray-900"><?php echo e($appointment->nomor_janji_temu); ?></p>
        </div>
        <div>
            <label class="text-sm font-medium text-gray-500">Status</label>
            <p class="mt-1">
                <span class="px-3 py-1 text-sm rounded-full 
                    <?php if($appointment->status == 'selesai'): ?> bg-green-100 text-green-800
                    <?php elseif($appointment->status == 'dibatalkan'): ?> bg-red-100 text-red-800
                    <?php elseif($appointment->status == 'check_in'): ?> bg-blue-100 text-blue-800
                    <?php elseif($appointment->status == 'sedang_dilayani'): ?> bg-purple-100 text-purple-800
                    <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                    <?php echo e(ucfirst(str_replace('_', ' ', $appointment->status))); ?>

                </span>
            </p>
        </div>

        <?php if($appointment->status == 'check_in' && $appointment->queue_code): ?>
        <div class="md:col-span-2 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <div class="flex justify-between items-center">
                <div>
                    <label class="text-sm font-medium text-gray-600">Queue Number</label>
                    <p class="mt-1 text-4xl font-bold text-blue-600"><?php echo e($appointment->queue_code); ?></p>
                    <p class="text-sm text-gray-500 mt-1">Checked in at <?php echo e($appointment->checked_in_at->format('H:i')); ?></p>
                </div>
                <div>
                    <a href="<?php echo e(route('queue.ticket', $appointment)); ?>" target="_blank" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Queue Ticket
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div>
            <label class="text-sm font-medium text-gray-500">Patient</label>
            <p class="mt-1 text-gray-900">
                <a href="<?php echo e(route('patients.show', $appointment->pasien)); ?>" class="text-blue-600 hover:underline">
                    <?php echo e($appointment->pasien->nama_lengkap); ?> (<?php echo e($appointment->pasien->mrn); ?>)
                </a>
            </p>
        </div>
        <div>
            <label class="text-sm font-medium text-gray-500">Doctor</label>
            <p class="mt-1 text-gray-900"><?php echo e($appointment->dokter->user->nama); ?></p>
            <p class="text-sm text-gray-500"><?php echo e($appointment->dokter->departemen->nama); ?></p>
        </div>
        <div>
            <label class="text-sm font-medium text-gray-500">Date & Time</label>
            <p class="mt-1 text-gray-900"><?php echo e(\Carbon\Carbon::parse($appointment->tanggal_janji)->format('d F Y, H:i')); ?></p>
        </div>
        <div>
            <label class="text-sm font-medium text-gray-500">Type</label>
            <p class="mt-1 text-gray-900"><?php echo e(ucfirst(str_replace('_', ' ', $appointment->type))); ?></p>
        </div>
        <?php if($appointment->checked_in_at): ?>
        <div>
            <label class="text-sm font-medium text-gray-500">Check-in Time</label>
            <p class="mt-1 text-gray-900"><?php echo e(\Carbon\Carbon::parse($appointment->checked_in_at)->format('d F Y, H:i')); ?></p>
        </div>
        <?php endif; ?>
        <div class="md:col-span-2">
            <label class="text-sm font-medium text-gray-500">Reason for Visit</label>
            <p class="mt-1 text-gray-900"><?php echo e($appointment->reason ?: 'N/A'); ?></p>
        </div>
        <div class="md:col-span-2">
            <label class="text-sm font-medium text-gray-500">Notes</label>
            <p class="mt-1 text-gray-900"><?php echo e($appointment->catatan ?: 'N/A'); ?></p>
        </div>
    </div>
</div>

<?php if($appointment->medicalRecord): ?>
<div class="mt-6 bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-xl font-semibold text-gray-800">Medical Record</h3>
    </div>
    <div class="p-6">
        <a href="<?php echo e(route('medical-records.show', $appointment->medicalRecord)); ?>" class="text-blue-600 hover:underline">
            View Medical Record
        </a>
    </div>
</div>
<?php endif; ?>

<?php if($appointment->tagihan): ?>
<div class="mt-6 bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-xl font-semibold text-gray-800">Invoice</h3>
    </div>
    <div class="p-6">
        <a href="<?php echo e(route('billing.show', $appointment->tagihan)); ?>" class="text-blue-600 hover:underline">
            View Invoice (<?php echo e($appointment->tagihan->nomor_tagihan); ?>)
        </a>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\appointments\show.blade.php ENDPATH**/ ?>