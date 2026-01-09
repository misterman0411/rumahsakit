

<?php $__env->startSection('title', 'Operational Performance'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3">
                <a href="<?php echo e(route('management.index')); ?>" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Operational Performance</h1>
            </div>
            <p class="text-gray-600 mt-1">Lab, Radiology, Pharmacy & Clinic Statistics</p>
        </div>
        
        <!-- Period Filter -->
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-600">Period:</span>
            <div class="flex rounded-lg overflow-hidden border border-gray-300">
                <?php $__currentLoopData = ['today' => 'Today', 'week' => 'Week', 'month' => 'Month', 'quarter' => 'Quarter', 'year' => 'Year']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('management.operational', ['period' => $key])); ?>" 
                   class="px-4 py-2 text-sm <?php echo e($period === $key ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'); ?>">
                    <?php echo e($label); ?>

                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- Department Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Laboratory -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Laboratory</h3>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Orders</span>
                    <span class="font-bold"><?php echo e($labStats['total']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Completed</span>
                    <span class="font-bold text-green-600"><?php echo e($labStats['completed']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Pending</span>
                    <span class="font-bold text-yellow-600"><?php echo e($labStats['pending']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">In Progress</span>
                    <span class="font-bold text-blue-600"><?php echo e($labStats['in_progress']); ?></span>
                </div>
                <div class="pt-3 border-t">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm text-gray-600">Completion Rate</span>
                        <span class="text-sm font-bold"><?php echo e($labStats['completion_rate']); ?>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <?php $labWidth = "width: {$labStats['completion_rate']}%"; ?>
                        <div class="bg-blue-600 h-2 rounded-full" style="<?php echo \Illuminate\Support\Arr::toCssStyles($labWidth) ?>"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Radiology -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Radiology</h3>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Orders</span>
                    <span class="font-bold"><?php echo e($radStats['total']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Completed</span>
                    <span class="font-bold text-green-600"><?php echo e($radStats['completed']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Pending</span>
                    <span class="font-bold text-yellow-600"><?php echo e($radStats['pending']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Draft Reports</span>
                    <span class="font-bold text-orange-600"><?php echo e($radStats['draft']); ?></span>
                </div>
                <div class="pt-3 border-t">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm text-gray-600">Completion Rate</span>
                        <span class="text-sm font-bold"><?php echo e($radStats['completion_rate']); ?>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <?php $radWidth = "width: {$radStats['completion_rate']}%"; ?>
                        <div class="bg-purple-600 h-2 rounded-full" style="<?php echo \Illuminate\Support\Arr::toCssStyles($radWidth) ?>"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pharmacy -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800">Pharmacy</h3>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Prescriptions</span>
                    <span class="font-bold"><?php echo e($rxStats['total']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Completed</span>
                    <span class="font-bold text-green-600"><?php echo e($rxStats['completed']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Pending</span>
                    <span class="font-bold text-yellow-600"><?php echo e($rxStats['pending']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Verified</span>
                    <span class="font-bold text-blue-600"><?php echo e($rxStats['verified']); ?></span>
                </div>
                <div class="pt-3 border-t">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm text-gray-600">Completion Rate</span>
                        <span class="text-sm font-bold"><?php echo e($rxStats['completion_rate']); ?>%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <?php $rxWidth = "width: {$rxStats['completion_rate']}%"; ?>
                        <div class="bg-green-600 h-2 rounded-full" style="<?php echo \Illuminate\Support\Arr::toCssStyles($rxWidth) ?>"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl shadow-sm p-6 text-white">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-bold">Total Summary</h3>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-indigo-100">Total Orders</span>
                    <span class="font-bold text-xl"><?php echo e($labStats['total'] + $radStats['total'] + $rxStats['total']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-indigo-100">Completed</span>
                    <span class="font-bold text-xl"><?php echo e($labStats['completed'] + $radStats['completed'] + $rxStats['completed']); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-indigo-100">Pending</span>
                    <span class="font-bold text-xl text-yellow-300"><?php echo e($labStats['pending'] + $radStats['pending'] + $rxStats['pending']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pharmacy & Inventory Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-gray-800">💊 Pharmacy Inventory Management</h2>
            <div class="flex gap-4 text-sm">
                <div class="text-center">
                    <div class="text-gray-600">Total Items</div>
                    <div class="text-xl font-bold text-gray-800"><?php echo e($inventoryStats['total_items']); ?></div>
                </div>
                <div class="text-center">
                    <div class="text-gray-600">Total Value</div>
                    <div class="text-xl font-bold text-blue-600">Rp <?php echo e(number_format($inventoryStats['total_value'], 0, ',', '.')); ?></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Low Stock Alerts -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-red-800">Low Stock Alert</div>
                        <div class="text-sm text-red-600"><?php echo e($inventoryStats['low_stock_count']); ?> items</div>
                    </div>
                </div>
                <?php if($lowStockMedications->count() > 0): ?>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    <?php $__currentLoopData = $lowStockMedications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $med): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded p-2 text-sm">
                        <div class="font-semibold text-gray-800"><?php echo e($med->nama); ?></div>
                        <div class="flex justify-between text-xs text-gray-600">
                            <span>Stock: <?php echo e($med->stok); ?></span>
                            <span class="text-red-600">Min: <?php echo e($med->stok_minimum); ?></span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <p class="text-sm text-gray-600">All medications adequately stocked ✅</p>
                <?php endif; ?>
            </div>

            <!-- Expiring Soon -->
            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-orange-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-orange-800">Expiring Soon</div>
                        <div class="text-sm text-orange-600"><?php echo e($inventoryStats['expiring_soon_count']); ?> items (3 months)</div>
                    </div>
                </div>
                <?php if($expiringMedications->count() > 0): ?>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    <?php $__currentLoopData = $expiringMedications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $med): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded p-2 text-sm">
                        <div class="font-semibold text-gray-800"><?php echo e($med->nama); ?></div>
                        <div class="flex justify-between text-xs text-gray-600">
                            <span>Stock: <?php echo e($med->stok); ?></span>
                            <span class="text-orange-600">Exp: <?php echo e($med->tanggal_kadaluarsa->format('d M Y')); ?></span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <p class="text-sm text-gray-600">No medications expiring soon ✅</p>
                <?php endif; ?>
            </div>

            <!-- Top Medications -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-green-800">Top Prescribed</div>
                        <div class="text-sm text-green-600">Most ordered items</div>
                    </div>
                </div>
                <?php if($topMedications->count() > 0): ?>
                <div class="space-y-2 max-h-48 overflow-y-auto">
                    <?php $__currentLoopData = $topMedications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $med): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded p-2 text-sm">
                        <div class="font-semibold text-gray-800"><?php echo e($med->nama); ?></div>
                        <div class="flex justify-between text-xs text-gray-600">
                            <span><?php echo e($med->kode); ?></span>
                            <span class="text-green-600 font-bold"><?php echo e($med->prescription_count); ?>x</span>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <p class="text-sm text-gray-600">No prescription data</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Clinic Performance by Department -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Clinic Performance by Department</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Department</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Total Appointments</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Completed</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Completion Rate</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Progress</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $clinicStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $rate = $dept->total_appointments > 0 ? round($dept->completed_appointments / $dept->total_appointments * 100) : 0;
                        $rateWidth = "width: {$rate}%";
                    ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium"><?php echo e($dept->nama); ?></td>
                        <td class="px-4 py-3 text-center"><?php echo e($dept->total_appointments); ?></td>
                        <td class="px-4 py-3 text-center text-green-600 font-semibold"><?php echo e($dept->completed_appointments); ?></td>
                        <td class="px-4 py-3 text-center font-bold"><?php echo e($rate); ?>%</td>
                        <td class="px-4 py-3">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-indigo-600 h-2 rounded-full" style="<?php echo \Illuminate\Support\Arr::toCssStyles($rateWidth) ?>"></div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">No department data</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\management\operational.blade.php ENDPATH**/ ?>