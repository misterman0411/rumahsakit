<?php $__env->startSection('title', 'Add Charge'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800">Add New Charge</h2>
        <p class="text-sm text-gray-600 mt-1">
            Patient: <span class="font-medium"><?php echo e($inpatient->pasien->nama); ?></span>
        </p>
    </div>

    <form action="<?php echo e(route('inpatient.charges.store', $inpatient)); ?>" method="POST" class="p-6">
        <?php echo csrf_field(); ?>

        <div class="space-y-6">
            <!-- Charge Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Charge Date <span class="text-red-500">*</span>
                </label>
                <input type="date" name="charge_date" value="<?php echo e(old('charge_date', date('Y-m-d'))); ?>" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <?php $__errorArgs = ['charge_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Charge Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Charge Type <span class="text-red-500">*</span>
                </label>
                <select name="charge_type" id="charge_type" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select Charge Type</option>
                    <option value="room" <?php echo e(old('charge_type') == 'room' ? 'selected' : ''); ?>>🛏️ Room</option>
                    <option value="doctor_visit" <?php echo e(old('charge_type') == 'doctor_visit' ? 'selected' : ''); ?>>👨‍⚕️ Doctor Visit</option>
                    <option value="medication" <?php echo e(old('charge_type') == 'medication' ? 'selected' : ''); ?>>💊 Medication</option>
                    <option value="procedure" <?php echo e(old('charge_type') == 'procedure' ? 'selected' : ''); ?>>🔬 Procedure</option>
                    <option value="lab" <?php echo e(old('charge_type') == 'lab' ? 'selected' : ''); ?>>🧪 Laboratory</option>
                    <option value="radiology" <?php echo e(old('charge_type') == 'radiology' ? 'selected' : ''); ?>>📸 Radiology</option>
                    <option value="nursing_care" <?php echo e(old('charge_type') == 'nursing_care' ? 'selected' : ''); ?>>👩‍⚕️ Nursing Care</option>
                    <option value="consultation" <?php echo e(old('charge_type') == 'consultation' ? 'selected' : ''); ?>>💬 Consultation</option>
                    <option value="other" <?php echo e(old('charge_type') == 'other' ? 'selected' : ''); ?>>📋 Other</option>
                </select>
                <?php $__errorArgs = ['charge_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea name="description" rows="3" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter detailed description of the charge..."><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Quantity and Unit Price -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="jumlah" id="quantity" value="<?php echo e(old('quantity', 1)); ?>" 
                        min="0" step="0.01" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Unit Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Unit Price (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="harga_satuan" id="unit_price" value="<?php echo e(old('unit_price', 0)); ?>" 
                        min="0" step="0.01" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <?php $__errorArgs = ['unit_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Total Amount (Auto-calculated) -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700">Total Amount:</span>
                    <span class="text-2xl font-bold text-blue-900" id="total_amount">Rp 0</span>
                </div>
                <p class="text-xs text-gray-600 mt-1">Calculated automatically (Quantity × Unit Price)</p>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="<?php echo e(route('inpatient.charges.index', $inpatient)); ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Add Charge
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unit_price');
    const totalAmountDisplay = document.getElementById('total_amount');

    function calculateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        
        totalAmountDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }

    quantityInput.addEventListener('input', calculateTotal);
    unitPriceInput.addEventListener('input', calculateTotal);

    // Calculate on page load
    calculateTotal();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\inpatient\charges\create.blade.php ENDPATH**/ ?>