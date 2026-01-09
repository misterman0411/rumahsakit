<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Vital Signs Records</h1>
            <p class="text-gray-600 mt-2">Monitor and track patient vital signs</p>
        </div>
        <a href="<?php echo e(route('vital-signs.create')); ?>" 
            class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all shadow-sm">
            + Record Vital Signs
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" action="<?php echo e(route('vital-signs.index')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Patient</label>
                <select name="pasien_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Patients</option>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($patient->id); ?>" <?php echo e(request('patient_id') == $patient->id ? 'selected' : ''); ?>>
                            <?php echo e($patient->no_rekam_medis); ?> - <?php echo e($patient->nama); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Filter
                </button>
                <a href="<?php echo e(route('vital-signs.index')); ?>" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Vital Signs Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date/Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">BP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Temp (°C)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">HR (bpm)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">RR</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">SpO2 (%)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">BMI</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Recorded By</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $vitalSigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vital): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($vital->waktu_pengukuran ? $vital->waktu_pengukuran->format('d/m/Y H:i') : '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($vital->pasien->nama); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($vital->pasien->no_rekam_medis); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($vital->tekanan_darah_sistolik && $vital->tekanan_darah_diastolik ? $vital->tekanan_darah_sistolik . '/' . $vital->tekanan_darah_diastolik : '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($vital->suhu ? number_format($vital->suhu, 1) . '°C' : '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($vital->detak_jantung ? $vital->detak_jantung . ' bpm' : '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($vital->laju_pernapasan ? $vital->laju_pernapasan . '/min' : '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($vital->saturasi_oksigen ? number_format($vital->saturasi_oksigen, 1) . '%' : '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <?php if($vital->bmi): ?>
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        <?php if($vital->bmi < 18.5): ?> bg-yellow-100 text-yellow-800
                                        <?php elseif($vital->bmi >= 18.5 && $vital->bmi < 25): ?> bg-green-100 text-green-800
                                        <?php elseif($vital->bmi >= 25 && $vital->bmi < 30): ?> bg-orange-100 text-orange-800
                                        <?php else: ?> bg-red-100 text-red-800
                                        <?php endif; ?>">
                                        <?php echo e(number_format($vital->bmi, 1)); ?>

                                    </span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($vital->perawat->user->nama ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="<?php echo e(route('vital-signs.show', $vital)); ?>" 
                                        class="text-indigo-600 hover:text-indigo-900">View</a>
                                    <?php if(auth()->user()->hasAnyRole(['nurse', 'admin'])): ?>
                                    <a href="<?php echo e(route('vital-signs.edit', $vital)); ?>" 
                                        class="text-blue-600 hover:text-blue-900">Edit</a>
                                    <form action="<?php echo e(route('vital-signs.destroy', $vital)); ?>" method="POST" 
                                        class="inline" onsubmit="return confirm('Are you sure?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="mt-4 text-lg">No vital signs records found</p>
                                <p class="text-sm mt-2">Start by recording patient vital signs</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($vitalSigns->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-200">
                <?php echo e($vitalSigns->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views/vital-signs/index.blade.php ENDPATH**/ ?>