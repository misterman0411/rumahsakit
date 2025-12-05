

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Add New Room</h1>
            <p class="text-gray-600 mt-2">Add a new room to the hospital</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="<?php echo e(route('rooms.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="p-6 space-y-6">
                    <!-- Room Number -->
                    <div>
                        <label for="nomor_ruangan" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Ruangan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nomor_ruangan" id="nomor_ruangan" required value="<?php echo e(old('nomor_ruangan')); ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="e.g., 101, A-201">
                        <?php $__errorArgs = ['nomor_ruangan'];
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type -->
                        <div>
                            <label for="room_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                Room Type <span class="text-red-500">*</span>
                            </label>
                            <select name="room_type" id="room_type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Select Type --</option>
                                <option value="vip" <?php echo e(old('room_type') == 'vip' ? 'selected' : ''); ?>>VIP</option>
                                <option value="class_1" <?php echo e(old('room_type') == 'class_1' ? 'selected' : ''); ?>>Class 1</option>
                                <option value="class_2" <?php echo e(old('room_type') == 'class_2' ? 'selected' : ''); ?>>Class 2</option>
                                <option value="class_3" <?php echo e(old('room_type') == 'class_3' ? 'selected' : ''); ?>>Class 3</option>
                                <option value="icu" <?php echo e(old('room_type') == 'icu' ? 'selected' : ''); ?>>ICU</option>
                                <option value="emergency" <?php echo e(old('room_type') == 'emergency' ? 'selected' : ''); ?>>Emergency</option>
                            </select>
                            <?php $__errorArgs = ['room_type'];
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

                        <!-- Floor -->
                        <div>
                            <label for="floor" class="block text-sm font-semibold text-gray-700 mb-2">
                                Floor <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="floor" id="floor" required value="<?php echo e(old('floor')); ?>"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="e.g., 1, 2, 3">
                            <?php $__errorArgs = ['floor'];
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

                        <!-- Capacity -->
                        <div>
                            <label for="capacity" class="block text-sm font-semibold text-gray-700 mb-2">
                                Capacity (Beds) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="kapasitas" id="capacity" required value="<?php echo e(old('capacity', 1)); ?>"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="1">
                            <?php $__errorArgs = ['capacity'];
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

                        <!-- Daily Rate -->
                        <div>
                            <label for="daily_rate" class="block text-sm font-semibold text-gray-700 mb-2">
                                Daily Rate (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="daily_rate" id="daily_rate" required value="<?php echo e(old('daily_rate')); ?>"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="0.00">
                            <?php $__errorArgs = ['daily_rate'];
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

                        <!-- Status -->
                        <div class="md:col-span-2">
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                Status
                            </label>
                            <select name="status" id="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="available" <?php echo e(old('status', 'available') == 'available' ? 'selected' : ''); ?>>Available</option>
                                <option value="occupied" <?php echo e(old('status') == 'occupied' ? 'selected' : ''); ?>>Occupied</option>
                                <option value="maintenance" <?php echo e(old('status') == 'maintenance' ? 'selected' : ''); ?>>Under Maintenance</option>
                                <option value="reserved" <?php echo e(old('status') == 'reserved' ? 'selected' : ''); ?>>Reserved</option>
                            </select>
                            <?php $__errorArgs = ['status'];
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

                    <!-- Facilities -->
                    <div>
                        <label for="facilities" class="block text-sm font-semibold text-gray-700 mb-2">
                            Facilities
                        </label>
                        <textarea name="facilities" id="facilities" rows="3"
                            </select>
                            <?php $__errorArgs = ['status'];
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
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="<?php echo e(route('rooms.index')); ?>"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Save Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rs\hospital-management-system\resources\views/rooms/create.blade.php ENDPATH**/ ?>