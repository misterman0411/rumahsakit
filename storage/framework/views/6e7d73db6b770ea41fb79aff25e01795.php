<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Vital Signs Details</h1>
                <p class="text-gray-600 mt-2">Recorded on <?php echo e($vitalSign->recorded_at->format('d F Y, H:i')); ?></p>
            </div>
            <div class="flex space-x-3">
                <?php if(auth()->user()->hasAnyRole(['nurse', 'admin'])): ?>
                <a href="<?php echo e(route('vital-signs.edit', $vitalSign)); ?>" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit
                </a>
                <?php endif; ?>
                <a href="<?php echo e(route('vital-signs.index')); ?>" 
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to List
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Patient Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Patient Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Name</p>
                            <p class="font-semibold text-gray-900"><?php echo e($vitalSign->pasien->nama); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">MRN</p>
                            <p class="font-semibold text-gray-900"><?php echo e($vitalSign->pasien->no_rekam_medis); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Age</p>
                            <p class="font-semibold text-gray-900"><?php echo e($vitalSign->pasien->tanggal_lahir->age); ?> years</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Gender</p>
                            <p class="font-semibold text-gray-900"><?php echo e(ucfirst($vitalSign->pasien->gender)); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Vital Signs Measurements -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Vital Signs Measurements</h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                        <!-- Blood Pressure -->
                        <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <p class="text-sm font-medium text-red-900">Blood Pressure</p>
                            </div>
                            <p class="text-2xl font-bold text-red-900"><?php echo e($vitalSign->blood_pressure ?? '-'); ?></p>
                            <p class="text-xs text-red-700 mt-1">mmHg</p>
                        </div>

                        <!-- Temperature -->
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <svg class="w-6 h-6 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <p class="text-sm font-medium text-orange-900">Temperature</p>
                            </div>
                            <p class="text-2xl font-bold text-orange-900"><?php echo e($vitalSign->temperature ?? '-'); ?></p>
                            <p class="text-xs text-orange-700 mt-1">°C</p>
                        </div>

                        <!-- Heart Rate -->
                        <div class="bg-gradient-to-br from-pink-50 to-pink-100 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <svg class="w-6 h-6 text-pink-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                                <p class="text-sm font-medium text-pink-900">Heart Rate</p>
                            </div>
                            <p class="text-2xl font-bold text-pink-900"><?php echo e($vitalSign->heart_rate ?? '-'); ?></p>
                            <p class="text-xs text-pink-700 mt-1">bpm</p>
                        </div>

                        <!-- Respiratory Rate -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5" />
                                </svg>
                                <p class="text-sm font-medium text-blue-900">Respiratory Rate</p>
                            </div>
                            <p class="text-2xl font-bold text-blue-900"><?php echo e($vitalSign->respiratory_rate ?? '-'); ?></p>
                            <p class="text-xs text-blue-700 mt-1">per minute</p>
                        </div>

                        <!-- Oxygen Saturation -->
                        <div class="bg-gradient-to-br from-cyan-50 to-cyan-100 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <svg class="w-6 h-6 text-cyan-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm font-medium text-cyan-900">SpO2</p>
                            </div>
                            <p class="text-2xl font-bold text-cyan-900"><?php echo e($vitalSign->oxygen_saturation ?? '-'); ?></p>
                            <p class="text-xs text-cyan-700 mt-1">%</p>
                        </div>

                        <!-- Weight -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                                </svg>
                                <p class="text-sm font-medium text-green-900">Weight</p>
                            </div>
                            <p class="text-2xl font-bold text-green-900"><?php echo e($vitalSign->weight ?? '-'); ?></p>
                            <p class="text-xs text-green-700 mt-1">kg</p>
                        </div>

                        <!-- Height -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <svg class="w-6 h-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>
                                <p class="text-sm font-medium text-purple-900">Height</p>
                            </div>
                            <p class="text-2xl font-bold text-purple-900"><?php echo e($vitalSign->height ?? '-'); ?></p>
                            <p class="text-xs text-purple-700 mt-1">cm</p>
                        </div>

                        <!-- BMI -->
                        <?php if($vitalSign->bmi): ?>
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <svg class="w-6 h-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                <p class="text-sm font-medium text-indigo-900">BMI</p>
                            </div>
                            <p class="text-2xl font-bold text-indigo-900"><?php echo e(number_format($vitalSign->bmi, 1)); ?></p>
                            <p class="text-xs text-indigo-700 mt-1">
                                <?php if($vitalSign->bmi < 18.5): ?> Underweight
                                <?php elseif($vitalSign->bmi < 25): ?> Normal
                                <?php elseif($vitalSign->bmi < 30): ?> Overweight
                                <?php else: ?> Obese
                                <?php endif; ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Notes -->
                <?php if($vitalSign->catatan): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Notes</h2>
                    <p class="text-gray-700 whitespace-pre-wrap"><?php echo e($vitalSign->catatan); ?></p>
                </div>
                <?php endif; ?>

                <!-- Recent Vital Signs -->
                <?php if($recentVitals->count() > 0): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Vital Signs History</h2>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $recentVitals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border-l-4 border-indigo-500 pl-4 py-2 bg-gray-50 rounded">
                            <p class="text-sm font-semibold text-gray-900"><?php echo e($recent->recorded_at->format('d M Y, H:i')); ?></p>
                            <div class="grid grid-cols-4 gap-2 mt-2 text-xs text-gray-600">
                                <div><span class="font-medium">BP:</span> <?php echo e($recent->blood_pressure ?? '-'); ?></div>
                                <div><span class="font-medium">Temp:</span> <?php echo e($recent->temperature ?? '-'); ?>°C</div>
                                <div><span class="font-medium">HR:</span> <?php echo e($recent->heart_rate ?? '-'); ?> bpm</div>
                                <div><span class="font-medium">SpO2:</span> <?php echo e($recent->oxygen_saturation ?? '-'); ?>%</div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Recording Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Recording Information</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Recorded At</p>
                            <p class="font-semibold text-gray-900"><?php echo e($vitalSign->recorded_at->format('d F Y')); ?></p>
                            <p class="text-sm text-gray-700"><?php echo e($vitalSign->recorded_at->format('H:i')); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Recorded By</p>
                            <p class="font-semibold text-gray-900"><?php echo e($vitalSign->recordedBy->nama ?? 'N/A'); ?></p>
                        </div>
                        <?php if($vitalSign->medicalRecord): ?>
                        <div>
                            <p class="text-sm text-gray-600">Medical Record</p>
                            <a href="<?php echo e(route('medical-records.show', $vitalSign->medicalRecord)); ?>" 
                                class="font-semibold text-indigo-600 hover:text-indigo-800">
                                <?php echo e($vitalSign->medicalRecord->record_number); ?>

                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Actions</h2>
                    <div class="space-y-3">
                        <a href="<?php echo e(route('vital-signs.edit', $vitalSign)); ?>" 
                            class="block w-full px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition-colors">
                            Edit Vital Signs
                        </a>
                        <a href="<?php echo e(route('patients.show', $vitalSign->pasien)); ?>" 
                            class="block w-full px-4 py-2 bg-gray-600 text-white text-center rounded-lg hover:bg-gray-700 transition-colors">
                            View Patient Profile
                        </a>
                        <form action="<?php echo e(route('vital-signs.destroy', $vitalSign)); ?>" method="POST" 
                            onsubmit="return confirm('Are you sure you want to delete this record?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                class="block w-full px-4 py-2 bg-red-600 text-white text-center rounded-lg hover:bg-red-700 transition-colors">
                                Delete Record
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\vital-signs\show.blade.php ENDPATH**/ ?>