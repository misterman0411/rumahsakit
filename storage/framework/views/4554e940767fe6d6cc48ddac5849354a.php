<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Tambah Rekam Medis</h1>
            <p class="text-gray-600 mt-2">Catat pemeriksaan dan diagnosis pasien</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="<?php echo e(route('medical-records.store')); ?>" method="POST">
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
                    <div>
                        <label for="dokter_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Dokter <span class="text-red-500">*</span>
                        </label>
                        <select name="dokter_id" id="dokter_id" required
                            class="select2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            data-placeholder="-- Pilih Dokter --"
                            <?php echo e(isset($currentDoctor) ? 'readonly' : ''); ?>>
                            <option value="">-- Pilih Dokter --</option>
                            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($doctor->id); ?>" 
                                    <?php echo e((old('dokter_id') == $doctor->id || (isset($currentDoctor) && $currentDoctor->id == $doctor->id)) ? 'selected' : ''); ?>>
                                    <?php echo e($doctor->user->name); ?> - <?php echo e($doctor->spesialisasi); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if(isset($currentDoctor)): ?>
                            <p class="text-sm text-gray-500 mt-1">✓ Auto-selected (Anda sedang login sebagai dokter)</p>
                        <?php endif; ?>
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

                    <!-- Appointment (Optional) -->
                    <div>
                        <label for="janji_temu_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Appointment (Opsional)
                        </label>
                        <select name="janji_temu_id" id="janji_temu_id"
                            class="select2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            data-placeholder="-- Pilih Appointment --"
                            data-has-current-doctor="<?php echo e(isset($currentDoctor) ? 'true' : 'false'); ?>">
                            <option value="">-- Pilih Appointment --</option>
                            <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($appointment->id); ?>" 
                                    data-patient-id="<?php echo e($appointment->pasien_id); ?>"
                                    data-doctor-id="<?php echo e($appointment->dokter_id); ?>"
                                    <?php echo e(old('janji_temu_id') == $appointment->id ? 'selected' : ''); ?>>
                                    <?php echo e($appointment->nomor_janji_temu); ?> - <?php echo e($appointment->pasien->nama); ?> - <?php echo e($appointment->tanggal_janji->format('d/m/Y')); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Jika dipilih, data pasien dan dokter akan otomatis terisi</p>
                        <?php $__errorArgs = ['janji_temu_id'];
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

                    <!-- Symptoms/Anamnesis -->
                    <div>
                        <label for="keluhan" class="block text-sm font-semibold text-gray-700 mb-2">
                            Anamnesis/Keluhan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="keluhan" id="keluhan" rows="4" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Riwayat penyakit sekarang dan gejala yang dialami pasien"><?php echo e(old('keluhan')); ?></textarea>
                        <?php $__errorArgs = ['keluhan'];
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

                    <!-- Vital Signs -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Vital Signs</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Tekanan Darah (mmHg)</label>
                                <input type="text" name="vital_signs[blood_pressure]" value="<?php echo e(old('vital_signs.blood_pressure')); ?>"
                                    placeholder="120/80"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Suhu (°C)</label>
                                <input type="text" name="vital_signs[temperature]" value="<?php echo e(old('vital_signs.temperature')); ?>"
                                    placeholder="36.5"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Nadi (bpm)</label>
                                <input type="text" name="vital_signs[heart_rate]" value="<?php echo e(old('vital_signs.heart_rate')); ?>"
                                    placeholder="80"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Pernapasan (per menit)</label>
                                <input type="text" name="vital_signs[respiratory_rate]" value="<?php echo e(old('vital_signs.respiratory_rate')); ?>"
                                    placeholder="20"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">SpO2 (%)</label>
                                <input type="text" name="vital_signs[oxygen_saturation]" value="<?php echo e(old('vital_signs.oxygen_saturation')); ?>"
                                    placeholder="98"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Berat Badan (kg)</label>
                                <input type="text" name="vital_signs[weight]" value="<?php echo e(old('vital_signs.weight')); ?>"
                                    placeholder="70"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- ICD-10 Primary -->
                    <div>
                        <label for="icd10_primary" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kode ICD-10 Diagnosis Primer
                        </label>
                        <input type="text" name="icd10_primary" id="icd10_primary" maxlength="10" value="<?php echo e(old('icd10_primary')); ?>"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Contoh: J18.9">
                        <p class="text-xs text-gray-500 mt-1">Kode ICD-10 untuk diagnosis utama (maksimal 10 karakter)</p>
                        <?php $__errorArgs = ['icd10_primary'];
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

                    <!-- ICD-10 Secondary -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kode ICD-10 Diagnosis Sekunder
                        </label>
                        <div id="icd10-secondary-container" class="space-y-2">
                            <?php if(old('icd10_secondary')): ?>
                                <?php $__currentLoopData = old('icd10_secondary'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex gap-2 icd10-secondary-item">
                                    <input type="text" name="icd10_secondary[]" maxlength="10" value="<?php echo e($code); ?>"
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Contoh: E11.9">
                                    <button type="button" onclick="this.parentElement.remove()"
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                        Hapus
                                    </button>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <button type="button" onclick="addIcd10Secondary()"
                            class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                            + Tambah Kode ICD-10 Sekunder
                        </button>
                        <p class="text-xs text-gray-500 mt-1">Kode ICD-10 untuk diagnosis tambahan/penyerta</p>
                    </div>

                    <!-- ICD-9 Procedures -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kode ICD-9-CM Prosedur/Tindakan
                        </label>
                        <div id="icd9-procedures-container" class="space-y-2">
                            <?php if(old('icd9_procedures')): ?>
                                <?php $__currentLoopData = old('icd9_procedures'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex gap-2 icd9-procedure-item">
                                    <input type="text" name="icd9_procedures[]" maxlength="10" value="<?php echo e($code); ?>"
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Contoh: 99.04">
                                    <button type="button" onclick="this.parentElement.remove()"
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                        Hapus
                                    </button>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <button type="button" onclick="addIcd9Procedure()"
                            class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                            + Tambah Kode ICD-9 Prosedur
                        </button>
                        <p class="text-xs text-gray-500 mt-1">Kode ICD-9-CM untuk prosedur/tindakan yang dilakukan</p>
                    </div>

                    <!-- Diagnosis -->
                    <div>
                        <label for="diagnosis" class="block text-sm font-semibold text-gray-700 mb-2">
                            Diagnosis Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea name="diagnosis" id="diagnosis" rows="4" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Diagnosis lengkap dalam bahasa medis"><?php echo e(old('diagnosis')); ?></textarea>
                        <?php $__errorArgs = ['diagnosis'];
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

                    <!-- Treatment Plan -->
                    <div>
                        <label for="treatment_plan" class="block text-sm font-semibold text-gray-700 mb-2">
                            Rencana Tindakan
                        </label>
                        <textarea name="treatment_plan" id="treatment_plan" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Rencana pengobatan dan tindakan yang akan dilakukan"><?php echo e(old('treatment_plan')); ?></textarea>
                        <?php $__errorArgs = ['treatment_plan'];
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

                    <!-- Recommendations -->
                    <div>
                        <label for="recommendations" class="block text-sm font-semibold text-gray-700 mb-2">
                            Rekomendasi & Edukasi
                        </label>
                        <textarea name="recommendations" id="recommendations" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Rekomendasi untuk pasien, edukasi kesehatan, atau rujukan"><?php echo e(old('recommendations')); ?></textarea>
                        <?php $__errorArgs = ['recommendations'];
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
                            Catatan Tambahan
                        </label>
                        <textarea name="catatan" id="notes" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Catatan tambahan jika ada"><?php echo e(old('notes')); ?></textarea>
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
                    <a href="<?php echo e(route('medical-records.index')); ?>"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Simpan Rekam Medis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addIcd10Secondary() {
    const container = document.getElementById('icd10-secondary-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2 icd10-secondary-item';
    div.innerHTML = `
        <input type="text" name="icd10_secondary[]" maxlength="10"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
            placeholder="Contoh: E11.9">
        <button type="button" onclick="this.parentElement.remove()"
            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            Hapus
        </button>
    `;
    container.appendChild(div);
}

function addIcd9Procedure() {
    const container = document.getElementById('icd9-procedures-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2 icd9-procedure-item';
    div.innerHTML = `
        <input type="text" name="icd9_procedures[]" maxlength="10"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
            placeholder="Contoh: 99.04">
        <button type="button" onclick="this.parentElement.remove()"
            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            Hapus
        </button>
    `;
    container.appendChild(div);
}

// Auto-populate patient and doctor when appointment is selected
document.getElementById('janji_temu_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
        const patientId = selectedOption.getAttribute('data-patient-id');
        const doctorId = selectedOption.getAttribute('data-doctor-id');
        const hasCurrentDoctor = this.getAttribute('data-has-current-doctor') === 'true';
        
        // Set patient
        if (patientId) {
            $('#pasien_id').val(patientId).trigger('change');
        }
        
        // Set doctor (only if not already set by current doctor)
        if (doctorId && !hasCurrentDoctor) {
            $('#dokter_id').val(doctorId).trigger('change');
        }
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\medical-records\create.blade.php ENDPATH**/ ?>