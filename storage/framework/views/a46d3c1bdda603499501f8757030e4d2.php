

<?php $__env->startSection('content'); ?>
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Multiple Invoice Payment</h2>
            <div class="flex gap-2">
                <a href="<?php echo e(route('billing.index')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                    Back
                </a>
            </div>
        </div>

        <div class="p-6">
            <!-- Invoice Header with Patient Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 pb-6 border-b">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Total Invoices</label>
                            <p class="mt-1 text-lg text-gray-900 font-semibold"><?php echo e(count($invoices)); ?> invoices</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Payment Date</label>
                            <p class="mt-1 text-gray-900"><?php echo e(now()->format('d F Y H:i')); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Status</label>
                            <p class="mt-1">
                                <span class="px-3 py-1 text-sm rounded-full bg-yellow-100 text-yellow-800">
                                    Pending Payment
                                </span>
                            </p>
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

            <!-- Invoice List -->
            <div class="mb-6 pb-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Details</h3>
                <div class="space-y-4">
                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-bold text-gray-800 text-lg"><?php echo e($invoice->nomor_tagihan); ?></p>
                                <p class="text-sm text-gray-600"><?php echo e($invoice->created_at->format('d M Y H:i')); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-blue-600">Rp <?php echo e(number_format($invoice->total, 0, ',', '.')); ?></p>
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $invoice->status))); ?>

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

            <!-- Invoice Summary -->
            <div class="mb-6 pb-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Summary</h3>
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal</span>
                            <span class="font-semibold">Rp <?php echo e(number_format($totalAmount, 0, ',', '.')); ?></span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Discount</span>
                            <span class="font-semibold">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Tax</span>
                            <span class="font-semibold">Rp 0</span>
                        </div>
                        <div class="border-t-2 border-gray-300 pt-3 flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">Total Amount</span>
                            <span class="text-2xl font-bold text-green-600">Rp <?php echo e(number_format($totalAmount, 0, ',', '.')); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Payment Method</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Manual Payment -->
                    <button onclick="showPaymentForm('manual')" 
                        class="text-left p-6 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition group">
                        <div class="flex items-center space-x-4">
                            <div class="bg-blue-100 text-blue-600 rounded-lg p-4 group-hover:bg-blue-500 group-hover:text-white transition">
                                <i class="fas fa-money-bill-wave text-3xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-800 text-lg">Manual Payment</p>
                                <p class="text-sm text-gray-600">Cash, Transfer, Card, Insurance</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-600"></i>
                        </div>
                    </button>

                    <!-- Midtrans Online -->
                    <button onclick="showPaymentForm('midtrans')" 
                        class="text-left p-6 border-2 border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition group">
                        <div class="flex items-center space-x-4">
                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg p-4">
                                <i class="fas fa-credit-card text-3xl"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-800 text-lg">Midtrans Online</p>
                                <p class="text-sm text-gray-600">Credit Card, E-Wallet, Bank Transfer</p>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 group-hover:text-purple-600"></i>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold mb-1">Payment Information</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>All <?php echo e(count($invoices)); ?> invoices will be paid at once</li>
                            <li>Invoice status will automatically change to "Paid"</li>
                            <li>Payment receipt will be generated for each invoice</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Manual Payment Form Modal -->
<div id="manualPaymentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4 pb-3 border-b">
            <h3 class="text-xl font-semibold text-gray-900">Manual Payment</h3>
            <button onclick="closePaymentModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form action="<?php echo e(route('billing.payment-multiple')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="tagihan_ids" value="<?php echo e(json_encode($invoices->pluck('id'))); ?>">

            <div class="space-y-4">
                <div class="bg-blue-50 p-4 rounded-lg mb-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">Total Pembayaran:</span>
                        <span class="text-xl font-bold text-blue-600">Rp <?php echo e(number_format($totalAmount, 0, ',', '.')); ?></span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Metode Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <select name="metode_pembayaran" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Metode --</option>
                        <option value="tunai">💵 Cash (Tunai)</option>
                        <option value="kartu_kredit">💳 Credit Card</option>
                        <option value="kartu_debit">💳 Debit Card</option>
                        <option value="transfer">🏦 Bank Transfer</option>
                        <option value="asuransi">🏥 Insurance</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_pembayaran" value="<?php echo e(date('Y-m-d')); ?>" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                    <textarea name="catatan" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                </div>
            </div>

            <div class="mt-6 flex space-x-3">
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fas fa-check mr-2"></i>
                    Proses Pembayaran
                </button>
                <button type="button" onclick="closePaymentModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Midtrans Payment Form -->
<form id="midtransPaymentForm" action="<?php echo e(route('billing.payment-multiple-midtrans')); ?>" method="POST" class="hidden">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="tagihan_ids" value="<?php echo e(json_encode($invoices->pluck('id'))); ?>">
</form>

<script>
function showPaymentForm(type) {
    if (type === 'manual') {
        document.getElementById('manualPaymentModal').classList.remove('hidden');
    } else if (type === 'midtrans') {
        // Submit midtrans form directly
        document.getElementById('midtransPaymentForm').submit();
    }
}

function closePaymentModal() {
    document.getElementById('manualPaymentModal').classList.add('hidden');
}

// Close modal on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closePaymentModal();
    }
});

// Close modal when clicking outside
document.getElementById('manualPaymentModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closePaymentModal();
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views/billing/payment-multiple-detail.blade.php ENDPATH**/ ?>