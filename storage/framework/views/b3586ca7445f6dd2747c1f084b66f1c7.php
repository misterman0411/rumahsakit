<?php $__env->startSection('title', 'Edit Daily Log'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Daily Log</h2>
        <p class="text-sm text-gray-600 mt-1">
            Patient: <span class="font-medium"><?php echo e($inpatient->pasien->nama); ?></span>
        </p>
    </div>

    <form action="<?php echo e(route('inpatient.daily-logs.update', [$inpatient, $log])); ?>" method="POST" class="p-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="space-y-6">
            <!-- Type Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Log Type <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <?php $__currentLoopData = ['doctor_visit' => 'Doctor Visit', 'nursing_care' => 'Nursing Care', 'procedure' => 'Procedure', 'general' => 'General']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="relative flex cursor-pointer rounded-lg border p-4 hover:border-blue-500 transition-colors <?php echo e($log->type == $value ? 'border-blue-500 bg-blue-50' : ''); ?>">
                        <input type="radio" name="type" value="<?php echo e($value); ?>" class="sr-only" <?php echo e($log->type == $value ? 'checked' : ''); ?> required>
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-medium text-gray-900"><?php echo e($label); ?></span>
                            </span>
                        </span>
                        <svg class="h-5 w-5 text-blue-600 <?php echo e($log->type == $value ? '' : 'hidden'); ?>" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php $__errorArgs = ['type'];
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

            <!-- Doctor Selection -->
            <?php if(auth()->user()->role->nama == 'doctor' || auth()->user()->hasAnyRole(['admin'])): ?>
            <div id="doctor-field">
                <label class="block text-sm font-medium text-gray-700 mb-2">Doctor</label>
                <select name="dokter_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select Doctor</option>
                    <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($doctor->id); ?>" <?php echo e($log->dokter_id == $doctor->id ? 'selected' : ''); ?>>
                        Dr. <?php echo e($doctor->user->nama); ?> - <?php echo e($doctor->spesialisasi); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['dokter_id'];
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
            <?php endif; ?>

            <!-- Nurse Selection -->
            <?php if(auth()->user()->role->nama == 'nurse' || auth()->user()->hasAnyRole(['admin'])): ?>
            <div id="nurse-field">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nurse</label>
                <select name="perawat_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select Nurse</option>
                    <?php $__currentLoopData = $nurses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nurse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($nurse->id); ?>" <?php echo e($log->perawat_id == $nurse->id ? 'selected' : ''); ?>>
                        <?php echo e($nurse->user->nama); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['perawat_id'];
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
            <?php endif; ?>

            <!-- Vital Sign Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Link to Vital Sign (Optional)</label>
                <select name="vital_sign_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select Vital Sign Record</option>
                    <?php $__currentLoopData = $vitalSigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($vs->id); ?>" <?php echo e($log->vital_sign_id == $vs->id ? 'selected' : ''); ?>>
                        <?php echo e($vs->recorded_at->format('d M Y H:i')); ?> - 
                        BP: <?php echo e($vs->blood_pressure); ?>, HR: <?php echo e($vs->heart_rate); ?>, Temp: <?php echo e($vs->temperature); ?>°C
                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['vital_sign_id'];
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

            <!-- Progress Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Progress Notes <span class="text-red-500">*</span></label>
                <textarea name="progress_notes" rows="4" required 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter detailed progress notes..."><?php echo e(old('progress_notes', $log->progress_notes)); ?></textarea>
                <?php $__errorArgs = ['progress_notes'];
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

            <!-- Doctor Orders -->
            <div id="doctor-orders-field">
                <label class="block text-sm font-medium text-gray-700 mb-2">Doctor Orders</label>
                <textarea name="doctor_orders" rows="3" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter doctor's orders..."><?php echo e(old('doctor_orders', $log->dokter_orders)); ?></textarea>
                <?php $__errorArgs = ['doctor_orders'];
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

            <!-- Nurse Notes -->
            <div id="nurse-notes-field">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nurse Notes</label>
                <textarea name="nurse_notes" rows="3" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter nursing notes..."><?php echo e(old('nurse_notes', $log->perawat_notes)); ?></textarea>
                <?php $__errorArgs = ['nurse_notes'];
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

        <div class="mt-6 flex justify-end space-x-3">
            <a href="<?php echo e(route('inpatient.daily-logs.show', [$inpatient, $log])); ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Update Log
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeRadios = document.querySelectorAll('input[name="type"]');

    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            typeRadios.forEach(r => {
                r.parentElement.classList.remove('border-blue-500', 'bg-blue-50');
                r.parentElement.querySelector('svg').classList.add('hidden');
            });
            if(this.checked) {
                this.parentElement.classList.add('border-blue-500', 'bg-blue-50');
                this.parentElement.querySelector('svg').classList.remove('hidden');
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\inpatient\daily-logs\edit.blade.php ENDPATH**/ ?>