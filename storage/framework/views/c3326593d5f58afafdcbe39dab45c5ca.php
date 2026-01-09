<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Room</h1>
            <p class="text-gray-600 mt-2">Update room information - <?php echo e($room->nomor_ruangan); ?></p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="<?php echo e(route('rooms.update', $room)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="p-6 space-y-6">
                    <!-- Room Number (Read-only) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Room Number
                        </label>
                        <input type="text" value="<?php echo e($room->nomor_ruangan); ?>" readonly
                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type -->
                        <div>
                            <label for="room_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                Room Type <span class="text-red-500">*</span>
                            </label>
                            <select name="tipe_ruangan" id="tipe_ruangan" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="vip" <?php echo e(old('tipe_ruangan', $room->tipe_ruangan) == 'vip' ? 'selected' : ''); ?>>VIP</option>
                                <option value="kelas_1" <?php echo e(old('tipe_ruangan', $room->tipe_ruangan) == 'kelas_1' ? 'selected' : ''); ?>>Kelas 1</option>
                                <option value="kelas_2" <?php echo e(old('tipe_ruangan', $room->tipe_ruangan) == 'kelas_2' ? 'selected' : ''); ?>>Kelas 2</option>
                                <option value="kelas_3" <?php echo e(old('tipe_ruangan', $room->tipe_ruangan) == 'kelas_3' ? 'selected' : ''); ?>>Kelas 3</option>
                                <option value="icu" <?php echo e(old('tipe_ruangan', $room->tipe_ruangan) == 'icu' ? 'selected' : ''); ?>>ICU</option>
                                <option value="darurat" <?php echo e(old('tipe_ruangan', $room->tipe_ruangan) == 'darurat' ? 'selected' : ''); ?>>Darurat</option>
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
                            <input type="number" name="floor" id="floor" required value="<?php echo e(old('floor', $room->floor)); ?>"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
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

                        <!-- Daily Rate -->
                        <div>
                            <label for="daily_rate" class="block text-sm font-semibold text-gray-700 mb-2">
                                Daily Rate (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="daily_rate" id="daily_rate" required value="<?php echo e(old('daily_rate', $room->daily_rate)); ?>"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
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
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                Status
                            </label>
                            <select name="status" id="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="tersedia" <?php echo e(old('status', $room->status) == 'tersedia' ? 'selected' : ''); ?>>Tersedia</option>
                                <option value="terisi" <?php echo e(old('status', $room->status) == 'terisi' ? 'selected' : ''); ?>>Terisi</option>
                                <option value="perawatan" <?php echo e(old('status', $room->status) == 'perawatan' ? 'selected' : ''); ?>>Dalam Perawatan</option>
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

                    <!-- Capacity (Read-only) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Capacity (Beds)
                        </label>
                        <input type="text" value="<?php echo e($room->kapasitas); ?> beds" readonly
                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                        <p class="text-sm text-gray-500 mt-1">Capacity cannot be changed. Current beds: <?php echo e($room->tempatTidurs->count()); ?></p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="<?php echo e(route('rooms.show', $room)); ?>"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Update Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\rooms\edit.blade.php ENDPATH**/ ?>