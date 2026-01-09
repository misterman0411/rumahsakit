<?php $__env->startSection('title', 'Daily Log Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Daily Log Details</h2>
            <p class="text-sm text-gray-600 mt-1">
                <?php echo e($log->created_at->format('d F Y, H:i')); ?>

            </p>
        </div>
        <div class="flex space-x-2">
            <?php if(auth()->user()->hasAnyRole(['doctor', 'nurse', 'admin'])): ?>
            <a href="<?php echo e(route('inpatient.daily-logs.edit', [$inpatient, $log])); ?>" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md">
                Edit
            </a>
            <?php endif; ?>
            <a href="<?php echo e(route('inpatient.daily-logs.index', $inpatient)); ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                Back
            </a>
        </div>
    </div>

    <div class="p-6">
        <!-- Type Badge -->
        <div class="mb-6">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                <?php if($log->type == 'doctor_visit'): ?> bg-blue-100 text-blue-800
                <?php elseif($log->type == 'nursing_care'): ?> bg-green-100 text-green-800
                <?php elseif($log->type == 'procedure'): ?> bg-purple-100 text-purple-800
                <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                <?php echo e(ucfirst(str_replace('_', ' ', $log->type))); ?>

            </span>
        </div>

        <!-- Patient Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 p-4 bg-gray-50 rounded-lg">
            <div>
                <label class="text-sm font-medium text-gray-500">Patient</label>
                <p class="mt-1 text-lg font-semibold text-gray-900"><?php echo e($inpatient->pasien->nama); ?></p>
                <p class="text-sm text-gray-600"><?php echo e($inpatient->pasien->no_rekam_medis); ?></p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Room & Bed</label>
                <p class="mt-1 text-lg font-semibold text-gray-900">
                    <?php echo e($inpatient->ruangan->nomor_ruangan); ?> - <?php echo e($inpatient->tempatTidur->nomor_tempat_tidur); ?>

                </p>
                <p class="text-sm text-gray-600"><?php echo e($inpatient->ruangan->ruangan_type); ?></p>
            </div>
        </div>

        <!-- Staff Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <?php if($log->dokter): ?>
            <div class="border border-blue-200 bg-blue-50 rounded-lg p-4">
                <label class="text-sm font-medium text-blue-700">Doctor</label>
                <p class="mt-1 text-lg font-semibold text-gray-900">Dr. <?php echo e($log->dokter->user->nama); ?></p>
                <p class="text-sm text-gray-600"><?php echo e($log->dokter->spesialisasi); ?></p>
            </div>
            <?php endif; ?>

            <?php if($log->perawat): ?>
            <div class="border border-green-200 bg-green-50 rounded-lg p-4">
                <label class="text-sm font-medium text-green-700">Nurse</label>
                <p class="mt-1 text-lg font-semibold text-gray-900"><?php echo e($log->perawat->user->nama); ?></p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Vital Signs -->
        <?php if($log->vitalSign): ?>
        <div class="mb-6 border border-indigo-200 bg-indigo-50 rounded-lg p-4">
            <label class="text-sm font-medium text-indigo-700 mb-3 block">Vital Signs</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <div class="text-xs text-gray-600">Blood Pressure</div>
                    <div class="text-lg font-semibold text-gray-900"><?php echo e($log->vitalSign->blood_pressure); ?></div>
                </div>
                <div>
                    <div class="text-xs text-gray-600">Heart Rate</div>
                    <div class="text-lg font-semibold text-gray-900"><?php echo e($log->vitalSign->heart_rate); ?> bpm</div>
                </div>
                <div>
                    <div class="text-xs text-gray-600">Temperature</div>
                    <div class="text-lg font-semibold text-gray-900"><?php echo e($log->vitalSign->temperature); ?>°C</div>
                </div>
                <div>
                    <div class="text-xs text-gray-600">Respiratory Rate</div>
                    <div class="text-lg font-semibold text-gray-900"><?php echo e($log->vitalSign->respiratory_rate ?? 'N/A'); ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Progress Notes -->
        <?php if($log->progress_notes): ?>
        <div class="mb-6">
            <label class="text-sm font-medium text-gray-700 mb-2 block">Progress Notes</label>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-gray-900 whitespace-pre-wrap"><?php echo e($log->progress_notes); ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Doctor Orders -->
        <?php if($log->dokter_orders): ?>
        <div class="mb-6">
            <label class="text-sm font-medium text-gray-700 mb-2 block">Doctor Orders</label>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-gray-900 whitespace-pre-wrap"><?php echo e($log->dokter_orders); ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Nurse Notes -->
        <?php if($log->perawat_notes): ?>
        <div class="mb-6">
            <label class="text-sm font-medium text-gray-700 mb-2 block">Nurse Notes</label>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-gray-900 whitespace-pre-wrap"><?php echo e($log->perawat_notes); ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Metadata -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                <div>
                    <span class="font-medium">Created:</span> <?php echo e($log->created_at->format('d M Y, H:i')); ?>

                </div>
                <div>
                    <span class="font-medium">Updated:</span> <?php echo e($log->updated_at->format('d M Y, H:i')); ?>

                </div>
                <div>
                    <span class="font-medium">Time Ago:</span> <?php echo e($log->created_at->diffForHumans()); ?>

                </div>
            </div>
        </div>

        <!-- Actions -->
        <?php if(auth()->user()->hasAnyRole(['doctor', 'nurse', 'admin'])): ?>
        <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between items-center">
            <form action="<?php echo e(route('inpatient.daily-logs.destroy', [$inpatient, $log])); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this log?');">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                    Delete Log
                </button>
            </form>
            
            <a href="<?php echo e(route('inpatient.daily-logs.edit', [$inpatient, $log])); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Edit Log
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\inpatient\daily-logs\show.blade.php ENDPATH**/ ?>