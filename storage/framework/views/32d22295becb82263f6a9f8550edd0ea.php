

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Pembayaran Multiple Invoice</h1>
            <p class="text-gray-600 mt-2">Bayar <?php echo e(count($invoices)); ?> invoice sekaligus via Midtrans</p>
        </div>

        <!-- Invoice Summary Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white">Ringkasan Pembayaran</h2>
            </div>
            <div class="p-6">
                <div class="space-y-3 mb-6">
                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <div>
                            <p class="font-semibold text-gray-800"><?php echo e($invoice->nomor_tagihan); ?></p>
                            <p class="text-sm text-gray-600"><?php echo e($invoice->pasien->nama); ?></p>
                        </div>
                        <p class="font-bold text-indigo-600">Rp <?php echo e(number_format($invoice->total, 0, ',', '.')); ?></p>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="border-t-2 border-gray-300 pt-4">
                    <div class="flex justify-between items-center">
                        <p class="text-xl font-bold text-gray-800">Total Pembayaran</p>
                        <p class="text-2xl font-bold text-green-600">Rp <?php echo e(number_format($totalAmount, 0, ',', '.')); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Button -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden p-6">
            <button 
                id="pay-button"
                class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:scale-105">
                <i class="fas fa-credit-card mr-2"></i>
                Bayar Sekarang via Midtrans
            </button>

            <div class="mt-4 text-center">
                <a href="<?php echo e(route('billing.index')); ?>" class="text-gray-600 hover:text-gray-800 text-sm">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali ke Billing
                </a>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Metode Pembayaran Tersedia:</p>
                    <ul class="list-disc list-inside space-y-1">
                        <li>Credit Card / Debit Card</li>
                        <li>Bank Transfer (BCA, Mandiri, BNI, BRI, Permata)</li>
                        <li>E-Wallet (GoPay, ShopeePay, OVO)</li>
                        <li>Retail Store (Alfamart, Indomaret)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap Script -->
<script src="<?php echo e($snapUrl); ?>" data-client-key="<?php echo e($clientKey); ?>"></script>

<script>
document.getElementById('pay-button').addEventListener('click', function () {
    // Show loading state
    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
    
    // Trigger Snap payment
    snap.pay('<?php echo e($snapToken); ?>', {
        onSuccess: function(result) {
            console.log('Payment success:', result);
            window.location.href = '<?php echo e(route("billing.payment-multiple-success")); ?>?order_id=' + result.order_id;
        },
        onPending: function(result) {
            console.log('Payment pending:', result);
            window.location.href = '<?php echo e(route("billing.payment-multiple-success")); ?>?order_id=' + result.order_id;
        },
        onError: function(result) {
            console.log('Payment error:', result);
            alert('Pembayaran gagal! Silakan coba lagi.');
            document.getElementById('pay-button').disabled = false;
            document.getElementById('pay-button').innerHTML = '<i class="fas fa-credit-card mr-2"></i>Bayar Sekarang via Midtrans';
        },
        onClose: function() {
            console.log('Payment popup closed');
            document.getElementById('pay-button').disabled = false;
            document.getElementById('pay-button').innerHTML = '<i class="fas fa-credit-card mr-2"></i>Bayar Sekarang via Midtrans';
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\billing\payment-multiple-midtrans.blade.php ENDPATH**/ ?>