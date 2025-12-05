

<?php $__env->startSection('title', 'Invoice Details'); ?>

<?php $__env->startSection('content'); ?>
<?php
    // Calculate outstanding balance at the top
    $paidAmount = $invoice->payments->sum('amount');
    $outstanding = $invoice->total_amount - $paidAmount;
?>

<div class="max-w-4xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Invoice Details</h2>
            <div class="flex flex-wrap gap-2">
                <a href="<?php echo e(route('billing.index')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                    Back
                </a>
                <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md no-print">
                    Print Invoice
                </button>
                <?php if($outstanding > 0): ?>
                <button onclick="payWithMidtrans()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md no-print whitespace-nowrap" style="background-color: #9333ea !important;">
                    <svg class="inline w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    Pay Online (Midtrans)
                </button>
                <button onclick="checkPaymentStatus()" id="checkStatusBtn" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md no-print whitespace-nowrap">
                    <svg class="inline w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Check Payment Status
                </button>
                <button onclick="document.getElementById('paymentModal').classList.remove('hidden')" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md no-print">
                    Add Manual Payment
                </button>
                <?php endif; ?>
            </div>
        </div>

        <div class="p-6">
            <!-- Invoice Header -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 pb-6 border-b">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Information</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Invoice Number</label>
                            <p class="mt-1 text-lg text-gray-900 font-semibold"><?php echo e($invoice->invoice_number); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Invoice Date</label>
                            <p class="mt-1 text-gray-900"><?php echo e($invoice->created_at->format('d F Y H:i')); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Due Date</label>
                            <p class="mt-1 text-gray-900"><?php echo e($invoice->due_date ? $invoice->due_date->format('d F Y') : '-'); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Status</label>
                            <p class="mt-1">
                                <span class="px-3 py-1 text-sm rounded-full 
                                    <?php if($invoice->status == 'paid'): ?> bg-green-100 text-green-800
                                    <?php elseif($invoice->status == 'partially_paid'): ?> bg-yellow-100 text-yellow-800
                                    <?php elseif($invoice->status == 'cancelled'): ?> bg-gray-100 text-gray-800
                                    <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $invoice->status))); ?>

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
                            <p class="mt-1 text-gray-900 font-semibold"><?php echo e($invoice->patient->full_name); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">MRN</label>
                            <p class="mt-1 text-gray-900"><?php echo e($invoice->patient->mrn); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Phone</label>
                            <p class="mt-1 text-gray-900"><?php echo e($invoice->patient->phone ?? '-'); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Billable Details -->
            <div class="mb-6 pb-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Service Details</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Service Type:</span>
                            <span class="ml-2 text-gray-900 font-semibold"><?php echo e(class_basename($invoice->billable_type)); ?></span>
                        </div>
                        <?php if($invoice->billable): ?>
                            <?php if($invoice->billable_type == 'App\Models\Prescription'): ?>
                                <a href="<?php echo e(route('prescriptions.show', $invoice->billable->id)); ?>" class="text-blue-600 hover:text-blue-900 text-sm">View Details →</a>
                            <?php elseif($invoice->billable_type == 'App\Models\LaboratoryOrder'): ?>
                                <a href="<?php echo e(route('laboratory.show', $invoice->billable->id)); ?>" class="text-blue-600 hover:text-blue-900 text-sm">View Details →</a>
                            <?php elseif($invoice->billable_type == 'App\Models\RadiologyOrder'): ?>
                                <a href="<?php echo e(route('radiology.show', $invoice->billable->id)); ?>" class="text-blue-600 hover:text-blue-900 text-sm">View Details →</a>
                            <?php elseif($invoice->billable_type == 'App\Models\InpatientAdmission'): ?>
                                <a href="<?php echo e(route('inpatient.show', $invoice->billable->id)); ?>" class="text-blue-600 hover:text-blue-900 text-sm">View Details →</a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    
                    <?php if($invoice->billable_type == 'App\Models\Prescription' && $invoice->billable): ?>
                        <div class="space-y-2">
                            <div class="text-sm">
                                <span class="text-gray-500">Prescription Number:</span>
                                <span class="ml-2 text-gray-900"><?php echo e($invoice->billable->prescription_number); ?></span>
                            </div>
                            <div class="text-sm">
                                <span class="text-gray-500">Doctor:</span>
                                <span class="ml-2 text-gray-900"><?php echo e($invoice->billable->doctor->user->name ?? '-'); ?></span>
                            </div>
                            <div class="text-sm">
                                <span class="text-gray-500">Total Items:</span>
                                <span class="ml-2 text-gray-900"><?php echo e($invoice->billable->items->count()); ?> items</span>
                            </div>
                        </div>
                    <?php elseif($invoice->billable_type == 'App\Models\LaboratoryOrder' && $invoice->billable): ?>
                        <div class="space-y-2">
                            <div class="text-sm">
                                <span class="text-gray-500">Order Number:</span>
                                <span class="ml-2 text-gray-900"><?php echo e($invoice->billable->order_number); ?></span>
                            </div>
                            <div class="text-sm">
                                <span class="text-gray-500">Test Type:</span>
                                <span class="ml-2 text-gray-900"><?php echo e($invoice->billable->testType->name ?? '-'); ?></span>
                            </div>
                            <div class="text-sm">
                                <span class="text-gray-500">Doctor:</span>
                                <span class="ml-2 text-gray-900"><?php echo e($invoice->billable->doctor->user->name ?? '-'); ?></span>
                            </div>
                        </div>
                    <?php elseif($invoice->billable_type == 'App\Models\RadiologyOrder' && $invoice->billable): ?>
                        <div class="space-y-2">
                            <div class="text-sm">
                                <span class="text-gray-500">Order Number:</span>
                                <span class="ml-2 text-gray-900"><?php echo e($invoice->billable->order_number); ?></span>
                            </div>
                            <div class="text-sm">
                                <span class="text-gray-500">Test Type:</span>
                                <span class="ml-2 text-gray-900"><?php echo e($invoice->billable->testType->name ?? '-'); ?></span>
                            </div>
                            <div class="text-sm">
                                <span class="text-gray-500">Doctor:</span>
                                <span class="ml-2 text-gray-900"><?php echo e($invoice->billable->doctor->user->name ?? '-'); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Totals -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Invoice Summary</h3>
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal</span>
                            <span class="font-medium">Rp <?php echo e(number_format($invoice->subtotal, 0, ',', '.')); ?></span>
                        </div>
                        <?php if($invoice->discount > 0): ?>
                        <div class="flex justify-between text-gray-700">
                            <span>Discount</span>
                            <span class="font-medium text-red-600">- Rp <?php echo e(number_format($invoice->discount, 0, ',', '.')); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if($invoice->tax > 0): ?>
                        <div class="flex justify-between text-gray-700">
                            <span>Tax (10%)</span>
                            <span class="font-medium">Rp <?php echo e(number_format($invoice->tax, 0, ',', '.')); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="flex justify-between text-xl font-bold text-gray-900 border-t pt-3">
                            <span>Total Amount</span>
                            <span>Rp <?php echo e(number_format($invoice->total_amount, 0, ',', '.')); ?></span>
                        </div>
                        <?php if($paidAmount > 0): ?>
                        <div class="flex justify-between text-lg text-green-600 font-semibold">
                            <span>Paid Amount</span>
                            <span>Rp <?php echo e(number_format($paidAmount, 0, ',', '.')); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if($outstanding > 0): ?>
                        <div class="flex justify-between text-lg text-red-600 font-bold">
                            <span>Outstanding Balance</span>
                            <span>Rp <?php echo e(number_format($outstanding, 0, ',', '.')); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            <?php if($invoice->payments && $invoice->payments->count() > 0): ?>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment History</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Processed By</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $invoice->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?php echo e($payment->payment_number); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e($payment->payment_date ? date('d M Y H:i', strtotime($payment->payment_date)) : '-'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                    Rp <?php echo e(number_format($payment->amount, 0, ',', '.')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                        <?php echo e(ucfirst($payment->payment_method)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($payment->processedBy->name ?? '-'); ?>

                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<?php
    // Recalculate for modal (in case it's not calculated yet)
    if (!isset($outstanding)) {
        $paidAmount = $invoice->payments->sum('amount');
        $outstanding = $invoice->total_amount - $paidAmount;
    }
?>
<div id="paymentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Add Payment</h3>
            <form action="<?php echo e(route('billing.payment', $invoice)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Amount *</label>
                        <input type="number" name="amount" step="0.01" required
                            value="<?php echo e($outstanding); ?>"
                            max="<?php echo e($outstanding); ?>"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <p class="text-xs text-gray-500 mt-1">Outstanding: Rp <?php echo e(number_format($outstanding, 0, ',', '.')); ?></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Payment Date *</label>
                        <input type="datetime-local" name="payment_date" required
                            value="<?php echo e(now()->format('Y-m-d\TH:i')); ?>"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Payment Method *</label>
                        <select name="payment_method" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Select Method --</option>
                            <option value="cash">Cash</option>
                            <option value="card">Card/Debit</option>
                            <option value="transfer">Bank Transfer</option>
                            <option value="insurance">Insurance</option>
                            <option value="bpjs">BPJS</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="document.getElementById('paymentModal').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Process Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
@media print {
    /* Hide elements when printing */
    nav, .sidebar, button, .no-print {
        display: none !important;
    }
    
    /* Hide Back and Add Payment buttons */
    .px-6.py-4.border-b .flex.space-x-2 {
        display: none !important;
    }
    
    /* Hide payment modal */
    #paymentModal {
        display: none !important;
    }
    
    /* Adjust page for printing */
    body {
        margin: 0;
        padding: 20px;
    }
    
    .max-w-4xl {
        max-width: 100%;
    }
    
    .bg-white {
        box-shadow: none;
    }
    
    /* Make sure colors are visible in print */
    .bg-green-100, .bg-yellow-100, .bg-red-100, .bg-blue-100 {
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    
    /* Add hospital header for print */
    @page {
        margin: 1cm;
    }
    
    .print-header {
        display: block !important;
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #333;
    }
}

.print-header {
    display: none;
}
</style>

<script>
function payWithMidtrans() {
    // Show loading
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<svg class="animate-spin inline w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...';

    // Request snap token from server
    fetch('<?php echo e(route("billing.midtrans.create", $invoice)); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Buka Midtrans di tab baru
            const paymentUrl = 'https://app.sandbox.midtrans.com/snap/v2/vtweb/' + data.snap_token;
            
            // Reset button DULU sebelum buka tab
            btn.disabled = false;
            btn.innerHTML = originalText;
            
            // Buka tab baru
            const paymentWindow = window.open(paymentUrl, '_blank');
            
            if (!paymentWindow) {
                alert('Popup diblokir! Silakan izinkan popup untuk situs ini, lalu coba lagi.');
            }
        } else {
            alert('Gagal membuat pembayaran: ' + (data.message || 'Terjadi kesalahan'));
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memproses pembayaran');
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

// Check payment status and reload if paid
function checkPaymentStatus() {
    const btn = document.getElementById('checkStatusBtn');
    const originalText = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<svg class="animate-spin inline w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Verifying...';
    
    // Check if there's order_id in URL (from Midtrans callback)
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get('order_id');
    
    if (orderId) {
        // We have order_id, check its status directly
        checkSpecificOrder(orderId, btn, originalText);
    } else {
        // No order_id, do general verification
        generalVerification(btn, originalText);
    }
}

function checkSpecificOrder(orderId, btn, originalText) {
    fetch('<?php echo e(route("billing.midtrans.check", ":orderId")); ?>'.replace(':orderId', orderId), {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.data) {
            const status = data.data.transaction_status;
            if (status === 'settlement' || status === 'capture') {
                // Payment successful, update invoice
                updateInvoiceStatus(orderId, btn, originalText);
            } else {
                alert('Payment status: ' + status);
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        } else {
            alert('Transaction not found');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error checking payment status');
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

function updateInvoiceStatus(orderId, btn, originalText) {
    // Call verify endpoint to update invoice
    generalVerification(btn, originalText);
}

function generalVerification(btn, originalText) {
    // Call API to verify payment with Midtrans
    fetch('<?php echo e(route("billing.midtrans.verify", $invoice)); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            // Remove URL parameters and reload
            window.location.href = '<?php echo e(route("billing.show", $invoice)); ?>';
        } else {
            alert(data.message || 'No payment found');
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error checking payment status');
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}
</script>

<script>
// Auto-detect return from Midtrans
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const orderId = urlParams.get('order_id');
    const transactionStatus = urlParams.get('transaction_status');
    
    if (orderId && transactionStatus) {
        // User kembali dari Midtrans
        if (transactionStatus === 'settlement' || transactionStatus === 'capture') {
            // Pembayaran berhasil - reload halaman untuk update status
            setTimeout(() => {
                window.location.href = '<?php echo e(route("billing.show", $invoice)); ?>';
            }, 1000);
            
            // Tampilkan pesan sukses
            const alert = document.createElement('div');
            alert.className = 'mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded';
            alert.innerHTML = '<strong>Sukses!</strong> Pembayaran berhasil. Mohon tunggu konfirmasi dari sistem.';
            document.querySelector('.container').insertBefore(alert, document.querySelector('.container').firstChild);
        } else if (transactionStatus === 'pending') {
            const alert = document.createElement('div');
            alert.className = 'mb-4 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded';
            alert.innerHTML = '<strong>Info!</strong> Pembayaran sedang diproses.';
            document.querySelector('.container').insertBefore(alert, document.querySelector('.container').firstChild);
        } else {
            const alert = document.createElement('div');
            alert.className = 'mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded';
            alert.innerHTML = '<strong>Error!</strong> Pembayaran gagal atau dibatalkan.';
            document.querySelector('.container').insertBefore(alert, document.querySelector('.container').firstChild);
        }
    }
});
</script>

<div class="print-header">
    <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 5px;">MediCare Hospital System</h1>
    <p style="font-size: 14px; color: #666;">Jl. Kesehatan No. 123, Jakarta | Tel: (021) 1234-5678</p>
    <h2 style="font-size: 18px; font-weight: bold; margin-top: 15px;">INVOICE / TAGIHAN</h2>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rs\hospital-management-system\resources\views/billing/show.blade.php ENDPATH**/ ?>