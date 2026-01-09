<?php $__env->startSection('title', 'Daily Logs - ' . $inpatient->pasien->nama); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Daily Monitoring Logs</h2>
            <p class="text-sm text-gray-600 mt-1">
                Patient: <span class="font-medium"><?php echo e($inpatient->pasien->nama); ?></span> | 
                Room: <span class="font-medium"><?php echo e($inpatient->ruangan->nomor_ruangan); ?> - <?php echo e($inpatient->tempatTidur->nomor_tempat_tidur); ?></span>
            </p>
        </div>
        <?php if(auth()->user()->hasAnyRole(['doctor', 'nurse', 'admin'])): ?>
        <a href="<?php echo e(route('inpatient.daily-logs.create', $inpatient)); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
            + Add New Log
        </a>
        <?php endif; ?>
    </div>

    <!-- Stats Cards -->
    <div class="p-6 border-b border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="text-sm text-blue-600 font-medium">Total Logs</div>
                <div class="text-2xl font-bold text-blue-800"><?php echo e($logs->total()); ?></div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="text-sm text-green-600 font-medium">Doctor Visits</div>
                <div class="text-2xl font-bold text-green-800"><?php echo e($logs->where('type', 'doctor_visit')->count()); ?></div>
            </div>
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <div class="text-sm text-purple-600 font-medium">Nursing Care</div>
                <div class="text-2xl font-bold text-purple-800"><?php echo e($logs->where('type', 'nursing_care')->count()); ?></div>
            </div>
            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                <div class="text-sm text-indigo-600 font-medium">Last 24 Hours</div>
                <div class="text-2xl font-bold text-indigo-800"><?php echo e($logs->where('created_at', '>=', now()->subDay())->count()); ?></div>
            </div>
        </div>
    </div>

    <!-- Timeline View -->
    <div class="p-6">
        <?php if($logs->count() > 0): ?>
        <div class="space-y-4">
            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border-l-4 rounded-lg p-4 hover:shadow-md transition-shadow
                <?php if($log->type == 'doctor_visit'): ?> border-blue-500 bg-blue-50
                <?php elseif($log->type == 'nursing_care'): ?> border-green-500 bg-green-50
                <?php elseif($log->type == 'procedure'): ?> border-purple-500 bg-purple-50
                <?php else: ?> border-gray-500 bg-gray-50 <?php endif; ?>">
                
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center
                            <?php if($log->type == 'doctor_visit'): ?> bg-blue-600
                            <?php elseif($log->type == 'nursing_care'): ?> bg-green-600
                            <?php elseif($log->type == 'procedure'): ?> bg-purple-600
                            <?php else: ?> bg-gray-600 <?php endif; ?>">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <?php if($log->type == 'doctor_visit'): ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                <?php elseif($log->type == 'nursing_care'): ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                <?php else: ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                <?php endif; ?>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">
                                <?php echo e(ucfirst(str_replace('_', ' ', $log->type))); ?>

                            </div>
                            <div class="text-sm text-gray-600">
                                <?php echo e($log->created_at->format('d M Y, H:i')); ?>

                                <span class="text-gray-400">•</span>
                                <?php echo e($log->created_at->diffForHumans()); ?>

                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="<?php echo e(route('inpatient.daily-logs.show', [$inpatient, $log])); ?>" class="text-blue-600 hover:text-blue-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        <?php if(auth()->user()->hasAnyRole(['doctor', 'nurse', 'admin'])): ?>
                        <a href="<?php echo e(route('inpatient.daily-logs.edit', [$inpatient, $log])); ?>" class="text-yellow-600 hover:text-yellow-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <?php if($log->dokter): ?>
                    <div>
                        <span class="font-medium text-gray-700">Doctor:</span>
                        <span class="text-gray-900">Dr. <?php echo e($log->dokter->user->nama); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($log->perawat): ?>
                    <div>
                        <span class="font-medium text-gray-700">Nurse:</span>
                        <span class="text-gray-900"><?php echo e($log->perawat->user->nama); ?></span>
                    </div>
                    <?php endif; ?>

                    <?php if($log->vitalSign): ?>
                    <div class="md:col-span-2">
                        <span class="font-medium text-gray-700">Vital Signs:</span>
                        <span class="text-gray-900">
                            BP: <?php echo e($log->vitalSign->blood_pressure); ?>, 
                            HR: <?php echo e($log->vitalSign->heart_rate); ?> bpm, 
                            Temp: <?php echo e($log->vitalSign->temperature); ?>°C
                        </span>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if($log->progress_notes): ?>
                <div class="mt-3 pt-3 border-t border-gray-200">
                    <div class="font-medium text-gray-700 mb-1">Progress Notes:</div>
                    <div class="text-gray-900"><?php echo e($log->progress_notes); ?></div>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-6">
            <?php echo e($logs->links()); ?>

        </div>
        <?php else: ?>
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No logs yet</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating a new daily log.</p>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\inpatient\daily-logs\index.blade.php ENDPATH**/ ?>