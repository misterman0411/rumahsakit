<?php $__env->startSection('title', 'Financial Report'); ?>

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
                <h1 class="text-3xl font-bold text-gray-900">Financial Report</h1>
            </div>
            <p class="text-gray-600 mt-1">Revenue, Outstanding & Payment Analysis</p>
        </div>
        
        <!-- Period Filter -->
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-600">Period:</span>
            <div class="flex rounded-lg overflow-hidden border border-gray-300">
                <?php $__currentLoopData = ['today' => 'Today', 'week' => 'Week', 'month' => 'Month', 'quarter' => 'Quarter', 'year' => 'Year']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('management.financial', ['period' => $key])); ?>" 
                   class="px-4 py-2 text-sm <?php echo e($period === $key ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50'); ?>">
                    <?php echo e($label); ?>

                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-6 text-white">
            <div class="text-sm text-green-100">Total Revenue</div>
            <div class="text-3xl font-bold mt-2">Rp <?php echo e(number_format($stats['total_revenue'], 0, ',', '.')); ?></div>
            <div class="text-sm text-green-100 mt-2"><?php echo e(ucfirst($period)); ?> period</div>
        </div>
        
        <div class="bg-gradient-to-br from-red-500 to-rose-600 rounded-xl p-6 text-white">
            <div class="text-sm text-red-100">Outstanding</div>
            <div class="text-3xl font-bold mt-2">Rp <?php echo e(number_format($stats['total_outstanding'], 0, ',', '.')); ?></div>
            <div class="text-sm text-red-100 mt-2">Total unpaid invoices</div>
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl p-6 text-white">
            <div class="text-sm text-orange-100">Overdue</div>
            <div class="text-3xl font-bold mt-2"><?php echo e($stats['overdue_count']); ?></div>
            <div class="text-sm text-orange-100 mt-2">Past due invoices</div>
        </div>
        
        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-6 text-white">
            <div class="text-sm text-blue-100">Paid Invoices</div>
            <div class="text-3xl font-bold mt-2"><?php echo e($stats['paid_invoices']); ?></div>
            <div class="text-sm text-blue-100 mt-2">This period</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue by Payment Method -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Revenue by Payment Method</h2>
            <div class="space-y-4">
                <?php
                    $methodLabels = [
                        'tunai' => ['label' => 'Cash', 'color' => 'green', 'icon' => '💵'],
                        'kartu_kredit' => ['label' => 'Credit Card', 'color' => 'blue', 'icon' => '💳'],
                        'kartu_debit' => ['label' => 'Debit Card', 'color' => 'purple', 'icon' => '💳'],
                        'transfer' => ['label' => 'Bank Transfer', 'color' => 'indigo', 'icon' => '🏦'],
                        'asuransi' => ['label' => 'Insurance', 'color' => 'pink', 'icon' => '🏥'],
                    ];
                    $totalRev = $revenueByMethod->sum('total');
                ?>
                <?php $__empty_1 = true; $__currentLoopData = $revenueByMethod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $info = $methodLabels[$method->metode_pembayaran] ?? ['label' => $method->metode_pembayaran, 'color' => 'gray', 'icon' => '💰'];
                    $percentage = $totalRev > 0 ? round($method->total / $totalRev * 100) : 0;
                ?>
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium text-gray-700"><?php echo e($info['icon']); ?> <?php echo e($info['label']); ?></span>
                        <span class="text-sm font-bold text-gray-900">Rp <?php echo e(number_format($method->total, 0, ',', '.')); ?></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <?php $barStyle = "width: {$percentage}%"; $barClass = "bg-{$info['color']}-500"; ?>
                        <div class="<?php echo e($barClass); ?> h-2 rounded-full" style="<?php echo \Illuminate\Support\Arr::toCssStyles($barStyle) ?>"></div>
                    </div>
                    <div class="text-xs text-gray-500 mt-1"><?php echo e($method->count); ?> transactions (<?php echo e($percentage); ?>%)</div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500 text-center py-8">No payment data for this period</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Daily Revenue Trend -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Daily Revenue Trend</h2>
            <div class="space-y-2 max-h-80 overflow-y-auto">
                <?php $maxRevenue = $dailyRevenue->max('total') ?: 1; ?>
                <?php $__empty_1 = true; $__currentLoopData = $dailyRevenue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php $dayWidth = "width: " . round(($day->total / $maxRevenue) * 100) . "%"; ?>
                <div class="flex items-center gap-4">
                    <div class="w-24 text-sm text-gray-600"><?php echo e(\Carbon\Carbon::parse($day->date)->format('d M')); ?></div>
                    <div class="flex-1">
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-4 rounded-full" 
                                 style="<?php echo \Illuminate\Support\Arr::toCssStyles($dayWidth) ?>"></div>
                        </div>
                    </div>
                    <div class="w-32 text-right text-sm font-medium">Rp <?php echo e(number_format($day->total, 0, ',', '.')); ?></div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500 text-center py-8">No revenue data for this period</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Recent Payments (<?php echo e(ucfirst($period)); ?>)</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e($payment->created_at->format('d M Y H:i')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                            <?php echo e($payment->tagihan->nomor_tagihan ?? '-'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e($payment->tagihan->pasien->nama ?? 'Unknown'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e(ucfirst(str_replace('_', ' ', $payment->metode_pembayaran))); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-green-600 text-right">
                            Rp <?php echo e(number_format($payment->jumlah, 0, ',', '.')); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                            No payments found for this period.
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Outstanding Invoices -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Outstanding Invoices</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Invoice #</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Patient</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Amount</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Due Date</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $outstandingInvoices->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium"><?php echo e($invoice->nomor_tagihan); ?></td>
                        <td class="px-4 py-3 text-sm"><?php echo e($invoice->pasien->nama ?? '-'); ?></td>
                        <td class="px-4 py-3 text-sm font-bold text-red-600">Rp <?php echo e(number_format($invoice->total, 0, ',', '.')); ?></td>
                        <td class="px-4 py-3 text-sm"><?php echo e($invoice->jatuh_tempo ? $invoice->jatuh_tempo->format('d/m/Y') : '-'); ?></td>
                        <td class="px-4 py-3">
                            <?php if($invoice->jatuh_tempo && $invoice->jatuh_tempo < now()): ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Overdue</span>
                            <?php else: ?>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">No outstanding invoices 🎉</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($outstandingInvoices->count() > 10): ?>
        <div class="mt-4 text-center">
            <span class="text-sm text-gray-500">Showing 10 of <?php echo e($outstandingInvoices->count()); ?> invoices</span>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\rumahsakit\resources\views/management/financial.blade.php ENDPATH**/ ?>