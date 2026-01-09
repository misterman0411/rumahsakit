

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg">
        <!-- Success Banner -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-8 text-center">
            <div class="flex justify-center mb-4">
                <div class="bg-white rounded-full p-4">
                    <i class="fas fa-check-circle text-green-500 text-6xl"></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">Payment Successful!</h2>
            <p class="text-green-100 text-lg"><?php echo e(count($payments)); ?> invoice(s) have been paid successfully</p>
        </div>

        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Payment Receipt</h2>
            <div class="flex gap-2">
                <a href="<?php echo e(route('billing.index')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Billing
                </a>
                <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md no-print">
                    <i class="fas fa-print mr-2"></i>
                    Print Receipt
                </button>
            </div>
        </div>

        <div class="p-6">
            <!-- Payment Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 pb-6 border-b">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Payment Date</label>
                            <p class="mt-1 text-gray-900"><?php echo e($paymentDate->format('d F Y H:i')); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Payment Method</label>
                            <p class="mt-1 text-gray-900">
                                <?php if($paymentMethod === 'tunai'): ?>
                                    💵 Cash (Tunai)
                                <?php elseif($paymentMethod === 'kartu_kredit'): ?>
                                    💳 Credit Card
                                <?php elseif($paymentMethod === 'kartu_debit'): ?>
                                    💳 Debit Card
                                <?php elseif($paymentMethod === 'transfer'): ?>
                                    🏦 Bank Transfer
                                <?php elseif($paymentMethod === 'online'): ?>
                                    💳 Online Payment (Midtrans)
                                <?php elseif($paymentMethod === 'asuransi'): ?>
                                    🏥 Insurance
                                <?php else: ?>
                                    <?php echo e(ucfirst($paymentMethod)); ?>

                                <?php endif; ?>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Processed By</label>
                            <p class="mt-1 text-gray-900"><?php echo e($processedBy->nama ?? 'System'); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Total Invoices Paid</label>
                            <p class="mt-1 text-lg font-bold text-green-600"><?php echo e(count($payments)); ?> invoice(s)</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Name</label>
                            <p class="mt-1 text-gray-900 font-semibold"><?php echo e($patient->nama); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">MRN</label>
                            <p class="mt-1 text-gray-900"><?php echo e($patient->no_rekam_medis); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Phone</label>
                            <p class="mt-1 text-gray-900"><?php echo e($patient->telepon ?? '-'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice & Payment Details -->
            <div class="mb-6 pb-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Details</h3>
                <div class="space-y-4">
                    <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $invoice = $payment->tagihan;
                    ?>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-bold text-gray-800 text-lg"><?php echo e($invoice->nomor_tagihan); ?></p>
                                <p class="text-sm text-gray-600">
                                    <i class="far fa-calendar mr-1"></i>
                                    <?php echo e($invoice->created_at->format('d M Y H:i')); ?>

                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Payment #<?php echo e($payment->nomor_pembayaran); ?>

                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-green-600">Rp <?php echo e(number_format($payment->jumlah, 0, ',', '.')); ?></p>
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Lunas
                                </span>
                            </div>
                        </div>

                        <?php if($invoice->itemTagihan && $invoice->itemTagihan->count() > 0): ?>
                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <p class="text-xs font-semibold text-gray-600 mb-2">Service Details:</p>
                            <div class="space-y-1">
                                <?php $__currentLoopData = $invoice->itemTagihan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-700">• <?php echo e($item->deskripsi); ?></span>
                                    <span class="text-gray-600 font-medium">Rp <?php echo e(number_format($item->total, 0, ',', '.')); ?></span>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <!-- Total Summary -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Summary</h3>
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6 border-2 border-green-200">
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-700">
                            <span>Total Invoices:</span>
                            <span class="font-semibold"><?php echo e(count($payments)); ?> invoice(s)</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal:</span>
                            <span class="font-semibold">Rp <?php echo e(number_format($totalAmount, 0, ',', '.')); ?></span>
                        </div>
                        <div class="border-t-2 border-green-300 pt-3 flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">Total Paid:</span>
                            <span class="text-3xl font-bold text-green-600">Rp <?php echo e(number_format($totalAmount, 0, ',', '.')); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center gap-4 no-print">
                <a href="<?php echo e(route('billing.index')); ?>" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                    <i class="fas fa-list mr-2"></i>
                    View All Invoices
                </a>
                <button onclick="window.print()" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium">
                    <i class="fas fa-print mr-2"></i>
                    Print Receipt
                </button>
            </div>

            <!-- Footer Note -->
            <div class="mt-6 pt-6 border-t text-center text-sm text-gray-500">
                <p>Thank you for your payment. All invoices have been marked as paid.</p>
                <p class="mt-1">If you have any questions, please contact our billing department.</p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    body {
        background: white;
    }
    .shadow {
        box-shadow: none !important;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\billing\payment-multiple-success.blade.php ENDPATH**/ ?>