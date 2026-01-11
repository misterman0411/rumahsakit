<?php $__env->startSection('title', 'Billing & Invoices'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800">Billing & Invoices</h2>
    </div>

    <div class="p-6">
        <!-- Multiple Payment Button -->
        <div class="mb-4 flex items-center justify-between">
            <div id="multiplePaymentBar" class="hidden flex items-center space-x-3 bg-blue-50 px-4 py-3 rounded-lg border border-blue-200">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-blue-800 font-medium"><span id="selectedCount">0</span> invoice dipilih</span>
                <span class="text-blue-600">Total: Rp <span id="selectedTotal">0</span></span>
                <button type="button" onclick="openMultiplePaymentModal()" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Bayar Sekaligus
                </button>
                <button type="button" onclick="clearSelection()" class="px-3 py-2 text-blue-600 hover:text-blue-800">
                    Clear
                </button>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" action="<?php echo e(route('billing.index')); ?>" class="mb-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nomor invoice atau nama pasien..." class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All Status</option>
                    <option value="belum_dibayar" <?php echo e(request('status') == 'belum_dibayar' ? 'selected' : ''); ?>>Belum Dibayar</option>
                    <option value="dibayar_sebagian" <?php echo e(request('status') == 'dibayar_sebagian' ? 'selected' : ''); ?>>Dibayar Sebagian</option>
                    <option value="lunas" <?php echo e(request('status') == 'lunas' ? 'selected' : ''); ?>>Lunas</option>
                </select>
                <div class="flex space-x-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Filter
                    </button>
                    <?php if(request()->hasAny(['search', 'status'])): ?>
                    <a href="<?php echo e(route('billing.index')); ?>" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Reset
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <!-- Invoices Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-3 text-left">
                            <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)" 
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invoice No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-4">
                            <?php if($invoice->status == 'belum_dibayar'): ?>
                            <input type="checkbox" class="invoice-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" 
                                data-invoice-id="<?php echo e($invoice->id); ?>" 
                                data-amount="<?php echo e($invoice->total); ?>"
                                onchange="updateSelection()">
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?php echo e($invoice->nomor_tagihan); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php if($invoice->pasien): ?>
                                <div class="font-medium"><?php echo e($invoice->pasien->nama); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($invoice->pasien->no_rekam_medis); ?></div>
                            <?php else: ?>
                                <span class="text-gray-400">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($invoice->created_at->format('d M Y')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp <?php echo e(number_format($invoice->total, 0, ',', '.')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full 
                                <?php if($invoice->status == 'lunas'): ?> bg-green-100 text-green-800
                                <?php elseif($invoice->status == 'dibayar_sebagian'): ?> bg-yellow-100 text-yellow-800
                                <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $invoice->status))); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="<?php echo e(route('billing.show', $invoice)); ?>" class="text-blue-600 hover:text-blue-900">View</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            No invoices found
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            <?php echo e($invoices->links()); ?>

        </div>
    </div>
</div>

<!-- Multiple Payment Modal -->
<div id="multiplePaymentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4 pb-3 border-b">
            <h3 class="text-xl font-semibold text-gray-900">Pembayaran Multiple Invoice</h3>
            <button onclick="closeMultiplePaymentModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Payment Options Tabs -->
        <div class="mt-4 border-b border-gray-200">
            <nav class="flex -mb-px space-x-4">
                <button type="button" onclick="switchPaymentTab('manual')" 
                    id="tabManual"
                    class="payment-tab py-2 px-4 text-sm font-medium border-b-2 border-blue-500 text-blue-600">
                    💵 Manual Payment
                </button>
                <button type="button" onclick="switchPaymentTab('midtrans')" 
                    id="tabMidtrans"
                    class="payment-tab py-2 px-4 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    💳 Midtrans Online
                </button>
            </nav>
        </div>

        <!-- Summary -->
        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm text-gray-600">Jumlah Invoice:</span>
                <span class="font-semibold text-blue-900" id="modalInvoiceCount">0</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-600">Total Pembayaran:</span>
                <span class="text-xl font-bold text-blue-600">Rp <span id="modalTotal">0</span></span>
            </div>
        </div>

        <!-- Manual Payment Form -->
        <form id="manualPaymentForm" action="<?php echo e(route('billing.payment-multiple')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="tagihan_ids" id="selectedInvoiceIds">

            <div class="space-y-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Metode Pembayaran <span class="text-red-500">*</span>
                    </label>
                    <select name="metode_pembayaran" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Pilih Metode --</option>
                        <option value="cash">💵 Cash (Tunai)</option>
                        <option value="credit_card">💳 Credit Card</option>
                        <option value="debit_card">💳 Debit Card</option>
                        <option value="bank_transfer">🏦 Bank Transfer</option>
                        <option value="insurance">🏥 Insurance</option>
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
                    <svg class="inline w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Proses Pembayaran
                </button>
                <button type="button" onclick="closeMultiplePaymentModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Batal
                </button>
            </div>
        </form>

        <!-- Midtrans Payment Form -->
        <form id="midtransPaymentForm" action="<?php echo e(route('billing.payment-multiple-midtrans')); ?>" method="POST" class="hidden">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="tagihan_ids" id="selectedInvoiceIdsMidtrans">

            <div class="space-y-4 mt-4">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border border-blue-200">
                    <div class="flex items-start">
                        <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                        <div class="text-sm text-gray-700">
                            <p class="font-semibold mb-2">Pembayaran via Midtrans</p>
                            <p class="mb-2">Anda akan diarahkan ke halaman pembayaran Midtrans yang mendukung:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>Credit Card / Debit Card (Visa, Mastercard, JCB, Amex)</li>
                                <li>Bank Transfer (BCA, Mandiri, BNI, BRI, Permata)</li>
                                <li>E-Wallet (GoPay, ShopeePay, OVO, QRIS)</li>
                                <li>Retail Store (Alfamart, Indomaret)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex space-x-3">
                <button type="submit"
                    class="flex-1 px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-lg hover:shadow-xl transition duration-300">
                    <i class="fas fa-credit-card mr-2"></i>
                    Bayar dengan Midtrans
                </button>
                <button type="button" onclick="closeMultiplePaymentModal()"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleSelectAll(checkbox) {
    const checkboxes = document.querySelectorAll('.invoice-checkbox');
    checkboxes.forEach(cb => {
        cb.checked = checkbox.checked;
    });
    updateSelection();
}

function updateSelection() {
    const checkboxes = document.querySelectorAll('.invoice-checkbox:checked');
    const count = checkboxes.length;
    const bar = document.getElementById('multiplePaymentBar');
    const selectAllCheckbox = document.getElementById('selectAll');
    
    // Show/hide bar
    if (count > 0) {
        bar.classList.remove('hidden');
        bar.classList.add('flex');
    } else {
        bar.classList.add('hidden');
        bar.classList.remove('flex');
    }
    
    // Calculate total
    let total = 0;
    checkboxes.forEach(cb => {
        total += parseFloat(cb.dataset.amount);
    });
    
    // Update display
    document.getElementById('selectedCount').textContent = count;
    document.getElementById('selectedTotal').textContent = total.toLocaleString('id-ID');
    
    // Update select all checkbox
    const allCheckboxes = document.querySelectorAll('.invoice-checkbox');
    selectAllCheckbox.checked = allCheckboxes.length > 0 && count === allCheckboxes.length;
}

function clearSelection() {
    const checkboxes = document.querySelectorAll('.invoice-checkbox');
    checkboxes.forEach(cb => cb.checked = false);
    document.getElementById('selectAll').checked = false;
    updateSelection();
}

function openMultiplePaymentModal() {
    const checkboxes = document.querySelectorAll('.invoice-checkbox:checked');
    if (checkboxes.length === 0) {
        alert('Pilih minimal 1 invoice untuk dibayar');
        return;
    }
    
    // Get selected invoice IDs
    const ids = Array.from(checkboxes).map(cb => cb.dataset.invoiceId);
    
    // Redirect to payment detail page
    window.location.href = '<?php echo e(route("billing.payment-multiple.show")); ?>?invoice_ids=' + encodeURIComponent(JSON.stringify(ids));
}

function switchPaymentTab(tab) {
    const manualForm = document.getElementById('manualPaymentForm');
    const midtransForm = document.getElementById('midtransPaymentForm');
    const manualTab = document.getElementById('tabManual');
    const midtransTab = document.getElementById('tabMidtrans');
    
    if (tab === 'manual') {
        // Show manual form
        manualForm.classList.remove('hidden');
        midtransForm.classList.add('hidden');
        
        // Update tab styles
        manualTab.classList.remove('border-transparent', 'text-gray-500');
        manualTab.classList.add('border-blue-500', 'text-blue-600');
        midtransTab.classList.remove('border-blue-500', 'text-blue-600');
        midtransTab.classList.add('border-transparent', 'text-gray-500');
    } else {
        // Show midtrans form
        manualForm.classList.add('hidden');
        midtransForm.classList.remove('hidden');
        
        // Update tab styles
        midtransTab.classList.remove('border-transparent', 'text-gray-500');
        midtransTab.classList.add('border-blue-500', 'text-blue-600');
        manualTab.classList.remove('border-blue-500', 'text-blue-600');
        manualTab.classList.add('border-transparent', 'text-gray-500');
    }
}

function closeMultiplePaymentModal() {
    document.getElementById('multiplePaymentModal').classList.add('hidden');
}

// Close modal on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeMultiplePaymentModal();
    }
});

// Close modal when clicking outside
document.getElementById('multiplePaymentModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeMultiplePaymentModal();
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\rumahsakit\resources\views/billing/index.blade.php ENDPATH**/ ?>