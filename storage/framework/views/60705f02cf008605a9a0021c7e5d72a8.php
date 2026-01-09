<?php $__env->startSection('title', 'Rawat Inap Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="<?php echo e(route('inpatient.index')); ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-4 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>
        <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Rawat Inap Baru</h2>
        <p class="text-gray-500 mt-1">Input data rawat inap pasien</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <form method="POST" action="<?php echo e(route('inpatient.store')); ?>" class="p-8">
            <?php echo csrf_field(); ?>

            <!-- Patient Selection -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pasien <span class="text-red-500">*</span></label>
                <select name="pasien_id" required class="select2 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 <?php $__errorArgs = ['pasien_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" data-placeholder="Pilih Pasien">
                    <option value="">Pilih Pasien</option>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($patient->id); ?>" <?php echo e(old('pasien_id') == $patient->id ? 'selected' : ''); ?>>
                        <?php echo e($patient->nama); ?> - <?php echo e($patient->no_rekam_medis); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['pasien_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Doctor Selection -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Dokter Penanggung Jawab <span class="text-red-500">*</span></label>
                <select name="dokter_id" required class="select2 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 <?php $__errorArgs = ['dokter_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" data-placeholder="Pilih Dokter">
                    <option value="">Pilih Dokter</option>
                    <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($doctor->id); ?>" <?php echo e(old('dokter_id') == $doctor->id ? 'selected' : ''); ?>>
                        <?php echo e($doctor->user->nama); ?> - <?php echo e($doctor->spesialisasi); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['dokter_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Room Selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kamar <span class="text-red-500">*</span></label>
                    <select name="ruangan_id" id="ruangan_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 <?php $__errorArgs = ['ruangan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">Pilih Kamar</option>
                        <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($room->id); ?>" data-beds="<?php echo e(json_encode($room->tempatTidurs)); ?>" <?php echo e(old('ruangan_id') == $room->id ? 'selected' : ''); ?>>
                            <?php echo e($room->nomor_ruangan); ?> - <?php echo e($room->ruangan_type); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['ruangan_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Bed Selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tempat Tidur <span class="text-red-500">*</span></label>
                    <select name="tempat_tidur_id" id="tempat_tidur_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 <?php $__errorArgs = ['tempat_tidur_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">Pilih Tempat Tidur</option>
                    </select>
                    <?php $__errorArgs = ['tempat_tidur_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Admission Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Masuk <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="tanggal_masuk" value="<?php echo e(old('tanggal_masuk', now()->format('Y-m-d\TH:i'))); ?>" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 <?php $__errorArgs = ['admission_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['admission_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Admission Type -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Rawat Inap <span class="text-red-500">*</span></label>
                    <select name="jenis_masuk" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 <?php $__errorArgs = ['jenis_masuk'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="darurat" <?php echo e(old('jenis_masuk') == 'darurat' ? 'selected' : ''); ?>>Darurat (Emergency)</option>
                        <option value="elektif" <?php echo e(old('jenis_masuk') == 'elektif' ? 'selected' : ''); ?>>Elektif (Scheduled)</option>
                    </select>
                    <?php $__errorArgs = ['admission_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Reason -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Rawat Inap <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="4" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"><?php echo e(old('reason')); ?></textarea>
                <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-500"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="<?php echo e(route('inpatient.index')); ?>" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors font-semibold">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all font-semibold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('room_id').addEventListener('change', function() {
    const bedSelect = document.getElementById('bed_id');
    bedSelect.innerHTML = '<option value="">Pilih Tempat Tidur</option>';
    
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
        const beds = JSON.parse(selectedOption.dataset.beds);
        beds.forEach(bed => {
            if (bed.status === 'tersedia') {
                const option = document.createElement('option');
                option.value = bed.id;
                option.textContent = `Bed ${bed.bed_number}`;
                bedSelect.appendChild(option);
            }
        });
    }
});

// Trigger change if room already selected (for old input)
if (document.getElementById('room_id').value) {
    document.getElementById('room_id').dispatchEvent(new Event('change'));
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\inpatient\create.blade.php ENDPATH**/ ?>