

<?php $__env->startSection('title', 'Management Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Management Dashboard</h1>
            <p class="text-gray-600 mt-1">Executive Summary - <?php echo e(now()->format('d F Y')); ?></p>
        </div>
        <div class="text-sm text-gray-500">
            Last updated: <?php echo e(now()->format('H:i')); ?>

        </div>
    </div>

    <!-- Quick Navigation -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="<?php echo e(route('management.financial')); ?>" class="group bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-6 text-white hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold">Financial Report</h3>
                    <p class="text-green-100 text-sm">Revenue & Outstanding</p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('management.operational')); ?>" class="group bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-6 text-white hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold">Operational</h3>
                    <p class="text-blue-100 text-sm">Lab, Rad, Pharmacy, Clinic</p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('management.patient-flow')); ?>" class="group bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl p-6 text-white hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold">Patient Flow</h3>
                    <p class="text-purple-100 text-sm">Visits & Admissions</p>
                </div>
            </div>
        </a>

        <a href="<?php echo e(route('management.staff-performance')); ?>" class="group bg-gradient-to-br from-orange-500 to-red-600 rounded-xl p-6 text-white hover:shadow-xl transition-all hover:scale-105">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold">Staff Performance</h3>
                    <p class="text-orange-100 text-sm">Doctors & Technicians</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Executive Summary Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Financial Summary -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-800">💰 Financial Summary</h2>
                <a href="<?php echo e(route('management.financial')); ?>" class="text-sm text-blue-600 hover:underline">Detail →</a>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Today Revenue</span>
                    <span class="text-xl font-bold text-green-600">Rp <?php echo e(number_format($stats['today_revenue'], 0, ',', '.')); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">This Month</span>
                    <span class="text-xl font-bold text-blue-600">Rp <?php echo e(number_format($stats['month_revenue'], 0, ',', '.')); ?></span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t">
                    <span class="text-gray-600">Outstanding</span>
                    <span class="text-xl font-bold text-red-600">Rp <?php echo e(number_format($stats['unpaid_total'], 0, ',', '.')); ?></span>
                </div>
            </div>
        </div>

        <!-- Operational Summary -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-800">⚡ Pending Tasks</h2>
                <a href="<?php echo e(route('management.operational')); ?>" class="text-sm text-blue-600 hover:underline">Detail →</a>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">🔬 Laboratory</span>
                    <span class="text-xl font-bold <?php echo e($stats['lab_pending'] > 0 ? 'text-yellow-600' : 'text-green-600'); ?>"><?php echo e($stats['lab_pending']); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">📷 Radiology</span>
                    <span class="text-xl font-bold <?php echo e($stats['rad_pending'] > 0 ? 'text-yellow-600' : 'text-green-600'); ?>"><?php echo e($stats['rad_pending']); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">💊 Prescriptions</span>
                    <span class="text-xl font-bold <?php echo e($stats['rx_pending'] > 0 ? 'text-yellow-600' : 'text-green-600'); ?>"><?php echo e($stats['rx_pending']); ?></span>
                </div>
            </div>
        </div>

        <!-- Patient Summary -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-800">👥 Patient Overview</h2>
                <a href="<?php echo e(route('management.patient-flow')); ?>" class="text-sm text-blue-600 hover:underline">Detail →</a>
            </div>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Patients</span>
                    <span class="text-xl font-bold text-gray-800"><?php echo e(number_format($stats['total_patients'])); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Today Appointments</span>
                    <span class="text-xl font-bold text-blue-600"><?php echo e($stats['today_appointments']); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Active Inpatients</span>
                    <span class="text-xl font-bold text-purple-600"><?php echo e($stats['active_inpatients']); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Summary Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Staff Overview -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-800">👨‍⚕️ Staff Overview</h2>
                <a href="<?php echo e(route('management.staff-performance')); ?>" class="text-sm text-blue-600 hover:underline">Performance →</a>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-blue-600"><?php echo e($stats['total_doctors']); ?></div>
                    <div class="text-sm text-gray-600">Doctors</div>
                </div>
                <div class="bg-pink-50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-pink-600"><?php echo e($stats['total_nurses']); ?></div>
                    <div class="text-sm text-gray-600">Nurses</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-green-600"><?php echo e($stats['new_patients_today']); ?></div>
                    <div class="text-sm text-gray-600">New Patients Today</div>
                </div>
                <div class="bg-purple-50 rounded-lg p-4 text-center">
                    <div class="text-3xl font-bold text-purple-600"><?php echo e($stats['active_inpatients']); ?></div>
                    <div class="text-sm text-gray-600">Active Inpatients</div>
                </div>
            </div>
        </div>

        <!-- Pharmacy & Inventory Alerts -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-gray-800">💊 Pharmacy Inventory</h2>
                <a href="<?php echo e(route('management.operational')); ?>" class="text-sm text-blue-600 hover:underline">Detail →</a>
            </div>
            <div class="space-y-4">
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-sm text-gray-600">⚠️ Low Stock Items</div>
                            <div class="text-xs text-gray-500">Below minimum threshold</div>
                        </div>
                        <span class="text-2xl font-bold <?php echo e($stats['low_stock_items'] > 0 ? 'text-red-600' : 'text-green-600'); ?>">
                            <?php echo e($stats['low_stock_items']); ?>

                        </span>
                    </div>
                </div>
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-sm text-gray-600">⏰ Expiring Soon</div>
                            <div class="text-xs text-gray-500">Within 3 months</div>
                        </div>
                        <span class="text-2xl font-bold <?php echo e($stats['expiring_soon'] > 0 ? 'text-orange-600' : 'text-green-600'); ?>">
                            <?php echo e($stats['expiring_soon']); ?>

                        </span>
                    </div>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <div class="text-sm text-gray-600">💰 Total Inventory Value</div>
                            <div class="text-xs text-gray-500">Current stock value</div>
                        </div>
                        <span class="text-lg font-bold text-blue-600">
                            Rp <?php echo e(number_format($stats['total_inventory_value'], 0, ',', '.')); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\management\index.blade.php ENDPATH**/ ?>