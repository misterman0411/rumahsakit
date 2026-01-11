<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Buat Resep Obat Baru</h1>
            <p class="text-gray-600 mt-2">Tulis resep obat untuk pasien</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="<?php echo e(route('prescriptions.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="p-6 space-y-6">
                    <!-- Patient Selection -->
                    <div>
                        <label for="pasien_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Pasien <span class="text-red-500">*</span>
                        </label>
                        <select name="pasien_id" id="pasien_id" required
                            class="select2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            data-placeholder="-- Pilih Pasien --">
                            <option value="">-- Pilih Pasien --</option>
                            <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($patient->id); ?>" <?php echo e(old('pasien_id') == $patient->id ? 'selected' : ''); ?>>
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

                    <!-- Doctor Selection -->
                    <?php if($currentDoctor): ?>
                        <!-- Hidden field untuk dokter yang sedang login -->
                        <input type="hidden" name="dokter_id" value="<?php echo e($currentDoctor->id); ?>">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Dokter</label>
                            <p class="text-gray-800 font-medium"><?php echo e($currentDoctor->user->nama); ?> - <?php echo e($currentDoctor->spesialisasi); ?></p>
                        </div>
                    <?php else: ?>
                        <div>
                            <label for="dokter_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Dokter <span class="text-red-500">*</span>
                            </label>
                            <select name="dokter_id" id="dokter_id" required
                                class="select2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                data-placeholder="-- Pilih Dokter --">
                                <option value="">-- Pilih Dokter --</option>
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
                                <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Medications -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Daftar Obat <span class="text-red-500">*</span>
                        </label>
                        <div id="medicationsContainer" class="space-y-4">
                            <div class="medication-item border border-gray-200 rounded-lg p-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Obat</label>
                                        <select name="items[0][obat_id]" required
                                            class="select2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 medication-select"
                                            data-placeholder="-- Pilih Obat --">
                                            <option value="">-- Pilih Obat --</option>
                                            <?php $__currentLoopData = $medications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medication): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($medication->id); ?>" data-price="<?php echo e($medication->harga); ?>">
                                                    <?php echo e($medication->nama); ?> - Rp <?php echo e(number_format($medication->harga, 0, ',', '.')); ?> (Stok: <?php echo e($medication->stok); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah</label>
                                        <input type="number" name="items[0][jumlah]" min="1" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Dosis</label>
                                        <input type="text" name="items[0][dosis]" required placeholder="Contoh: 500mg"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Frekuensi</label>
                                        <input type="text" name="items[0][frekuensi]" required placeholder="Contoh: 3x sehari"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi</label>
                                        <input type="text" name="items[0][durasi]" required placeholder="Contoh: 7 hari"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Instruksi</label>
                                        <textarea name="items[0][instruksi]" rows="2"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                            placeholder="Contoh: Diminum sesudah makan"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="addMedication()" class="mt-4 text-indigo-600 hover:text-indigo-700 font-semibold">
                            + Tambah Obat
                        </button>
                        <?php $__errorArgs = ['items'];
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

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                            Catatan
                        </label>
                        <textarea name="catatan" id="notes" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Catatan tambahan untuk resep ini"><?php echo e(old('notes')); ?></textarea>
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
                    <a href="<?php echo e(route('prescriptions.index')); ?>"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Buat Resep
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let medicationIndex = 1;
// Parse medications data from server
const medicationsData = JSON.parse('<?php echo e(json_encode($medications)); ?>');

function addMedication() {
    const container = document.getElementById('medicationsContainer');
    const newMedication = `
        <div class="medication-item border border-gray-200 rounded-lg p-4">
            <div class="flex justify-between items-start mb-3">
                <h3 class="font-semibold text-gray-800">Obat #${medicationIndex + 1}</h3>
                <button type="button" onclick="this.closest('.medication-item').remove()"
                    class="text-red-600 hover:text-red-700 text-sm font-semibold">
                    Hapus
                </button>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Obat</label>
                    <select name="items[${medicationIndex}][obat_id]" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Pilih Obat --</option>
                        ${medicationsData.map(med => `
                            <option value="${med.id}" data-price="${med.harga}">
                                ${med.nama} - Rp ${new Intl.NumberFormat('id-ID').format(med.harga)} (Stok: ${med.stok})
                            </option>
                        `).join('')}
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah</label>
                    <input type="number" name="items[${medicationIndex}][jumlah]" min="1" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Dosis</label>
                    <input type="text" name="items[${medicationIndex}][dosis]" required placeholder="Contoh: 500mg"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Frekuensi</label>
                    <input type="text" name="items[${medicationIndex}][frekuensi]" required placeholder="Contoh: 3x sehari"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi</label>
                    <input type="text" name="items[${medicationIndex}][durasi]" required placeholder="Contoh: 7 hari"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Instruksi</label>
                    <textarea name="items[${medicationIndex}][instruksi]" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        placeholder="Contoh: Diminum sesudah makan"></textarea>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newMedication);
    medicationIndex++;
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\prescriptions\create.blade.php ENDPATH**/ ?>