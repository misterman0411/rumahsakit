<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Vital Signs</h1>
            <p class="text-gray-600 mt-2">Update patient vital signs measurement</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="<?php echo e(route('vital-signs.update', $vitalSign)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="p-6 space-y-6">
                    <!-- Patient Selection -->
                    <div>
                        <label for="pasien_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Patient <span class="text-red-500">*</span>
                        </label>
                        <select name="pasien_id" id="pasien_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Select Patient --</option>
                            <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($patient->id); ?>" <?php echo e(old('pasien_id', $vitalSign->pasien_id) == $patient->id ? 'selected' : ''); ?>>
                                    <?php echo e($patient->no_rekam_medis); ?> - <?php echo e($patient->nama); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['pasien_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Medical Record (Optional) -->
                    <div>
                        <label for="rekam_medis_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Link to Medical Record (Optional)
                        </label>
                        <select name="rekam_medis_id" id="rekam_medis_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Select Medical Record --</option>
                            <?php $__currentLoopData = $medicalRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($record->id); ?>" <?php echo e(old('rekam_medis_id', $vitalSign->medical_record_id) == $record->id ? 'selected' : ''); ?>>
                                    <?php echo e($record->record_number); ?> - <?php echo e($record->pasien->nama); ?> - <?php echo e($record->created_at->format('d/m/Y')); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['rekam_medis_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Recording Date/Time -->
                    <div>
                        <label for="recorded_at" class="block text-sm font-semibold text-gray-700 mb-2">
                            Recording Date & Time
                        </label>
                        <input type="datetime-local" name="recorded_at" id="recorded_at" 
                            value="<?php echo e(old('recorded_at', $vitalSign->recorded_at->format('Y-m-d\TH:i'))); ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <?php $__errorArgs = ['recorded_at'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Vital Signs Grid -->
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Vital Signs Measurements</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Blood Pressure -->
                            <div>
                                <label for="blood_pressure" class="block text-sm font-medium text-gray-700 mb-2">
                                    Blood Pressure (mmHg)
                                </label>
                                <input type="text" name="blood_pressure" id="blood_pressure" 
                                    value="<?php echo e(old('blood_pressure', $vitalSign->blood_pressure)); ?>"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="120/80">
                                <?php $__errorArgs = ['blood_pressure'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Temperature -->
                            <div>
                                <label for="temperature" class="block text-sm font-medium text-gray-700 mb-2">
                                    Temperature (°C)
                                </label>
                                <input type="number" step="0.1" name="temperature" id="temperature" 
                                    value="<?php echo e(old('temperature', $vitalSign->temperature)); ?>"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="36.5">
                                <?php $__errorArgs = ['temperature'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Heart Rate -->
                            <div>
                                <label for="heart_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                    Heart Rate (bpm)
                                </label>
                                <input type="number" name="heart_rate" id="heart_rate" 
                                    value="<?php echo e(old('heart_rate', $vitalSign->heart_rate)); ?>"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="80">
                                <?php $__errorArgs = ['heart_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Respiratory Rate -->
                            <div>
                                <label for="respiratory_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                    Respiratory Rate (per minute)
                                </label>
                                <input type="number" name="respiratory_rate" id="respiratory_rate" 
                                    value="<?php echo e(old('respiratory_rate', $vitalSign->respiratory_rate)); ?>"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="20">
                                <?php $__errorArgs = ['respiratory_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Oxygen Saturation -->
                            <div>
                                <label for="oxygen_saturation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Oxygen Saturation (%)
                                </label>
                                <input type="number" name="oxygen_saturation" id="oxygen_saturation" 
                                    value="<?php echo e(old('oxygen_saturation', $vitalSign->oxygen_saturation)); ?>"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="98">
                                <?php $__errorArgs = ['oxygen_saturation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Weight -->
                            <div>
                                <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                                    Weight (kg)
                                </label>
                                <input type="number" step="0.1" name="weight" id="weight" 
                                    value="<?php echo e(old('weight', $vitalSign->weight)); ?>"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="70.5">
                                <?php $__errorArgs = ['weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Height -->
                            <div>
                                <label for="height" class="block text-sm font-medium text-gray-700 mb-2">
                                    Height (cm)
                                </label>
                                <input type="number" step="0.1" name="height" id="height" 
                                    value="<?php echo e(old('height', $vitalSign->height)); ?>"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="170.0">
                                <?php $__errorArgs = ['height'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <p class="text-xs text-gray-500 mt-1">BMI will be calculated automatically</p>
                            </div>

                            <?php if($vitalSign->bmi): ?>
                            <!-- Current BMI Display -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Current BMI
                                </label>
                                <div class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                                    <span class="text-lg font-bold text-gray-900"><?php echo e(number_format($vitalSign->bmi, 1)); ?></span>
                                    <span class="text-sm text-gray-600 ml-2">
                                        <?php if($vitalSign->bmi < 18.5): ?> (Underweight)
                                        <?php elseif($vitalSign->bmi < 25): ?> (Normal)
                                        <?php elseif($vitalSign->bmi < 30): ?> (Overweight)
                                        <?php else: ?>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                            Notes
                        </label>
                        <textarea name="catatan" id="notes" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Any additional observations or notes"><?php echo e(old('notes', $vitalSign->catatan)); ?></textarea>
                        <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="<?php echo e(route('vital-signs.show', $vitalSign)); ?>"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Update Vital Signs
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\vital-signs\edit.blade.php ENDPATH**/ ?>