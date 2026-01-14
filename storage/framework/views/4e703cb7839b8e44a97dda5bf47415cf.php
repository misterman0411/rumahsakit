<?php $__env->startSection('title', 'Edit Patient'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Patient: <?php echo e($patient->nama); ?></h2>
    </div>

    <form action="<?php echo e(route('patients.update', $patient)); ?>" method="POST" class="p-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- MRN (Read Only) -->
            <div>
                <label class="block text-sm font-medium text-gray-700">MRN</label>
                <input type="text" value="<?php echo e($patient->no_rekam_medis); ?>" disabled
                    class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md">
            </div>

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                <input type="text" name="nama" id="name" required value="<?php echo e(old('nama', $patient->nama)); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                <?php $__errorArgs = ['nama'];
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

            <!-- Date of Birth -->
            <div>
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth *</label>
                <input type="date" name="tanggal_lahir" id="date_of_birth" required value="<?php echo e(old('tanggal_lahir', $patient->tanggal_lahir->format('Y-m-d'))); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Gender -->
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender *</label>
                <select name="jenis_kelamin" id="gender" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="laki_laki" <?php echo e(old('jenis_kelamin', $patient->jenis_kelamin) == 'laki_laki' ? 'selected' : ''); ?>>Laki-laki</option>
                    <option value="perempuan" <?php echo e(old('jenis_kelamin', $patient->jenis_kelamin) == 'perempuan' ? 'selected' : ''); ?>>Perempuan</option>
                </select>
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone *</label>
                <input type="text" name="telepon" id="phone" required value="<?php echo e(old('telepon', $patient->telepon)); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="<?php echo e(old('email', $patient->email)); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- NIK -->
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK (Nomor Induk Kependudukan)</label>
                <input type="text" name="nik" id="nik" maxlength="16" value="<?php echo e(old('nik', $patient->nik)); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="16 digit NIK">
                <?php $__errorArgs = ['nik'];
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

            <!-- Religion -->
            <div>
                <label for="religion" class="block text-sm font-medium text-gray-700">Agama</label>
                <select name="agama" id="religion"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Agama</option>
                    <option value="islam" <?php echo e(old('agama', $patient->agama) == 'islam' ? 'selected' : ''); ?>>Islam</option>
                    <option value="kristen" <?php echo e(old('agama', $patient->agama) == 'kristen' ? 'selected' : ''); ?>>Kristen</option>
                    <option value="katolik" <?php echo e(old('agama', $patient->agama) == 'katolik' ? 'selected' : ''); ?>>Katolik</option>
                    <option value="hindu" <?php echo e(old('agama', $patient->agama) == 'hindu' ? 'selected' : ''); ?>>Hindu</option>
                    <option value="buddha" <?php echo e(old('agama', $patient->agama) == 'buddha' ? 'selected' : ''); ?>>Buddha</option>
                    <option value="konghucu" <?php echo e(old('agama', $patient->agama) == 'konghucu' ? 'selected' : ''); ?>>Konghucu</option>
                    <option value="other" <?php echo e(old('agama', $patient->agama) == 'other' ? 'selected' : ''); ?>>Lainnya</option>
                </select>
            </div>

            <!-- Marital Status -->
            <div>
                <label for="marital_status" class="block text-sm font-medium text-gray-700">Status Pernikahan</label>
                <select name="status_pernikahan" id="marital_status"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Status</option>
                    <option value="belum_menikah" <?php echo e(old('status_pernikahan', $patient->status_pernikahan) == 'belum_menikah' ? 'selected' : ''); ?>>Belum Menikah</option>
                    <option value="menikah" <?php echo e(old('status_pernikahan', $patient->status_pernikahan) == 'menikah' ? 'selected' : ''); ?>>Menikah</option>
                    <option value="cerai" <?php echo e(old('status_pernikahan', $patient->status_pernikahan) == 'cerai' ? 'selected' : ''); ?>>Cerai</option>
                    <option value="janda_duda" <?php echo e(old('status_pernikahan', $patient->status_pernikahan) == 'janda_duda' ? 'selected' : ''); ?>>Duda/Janda</option>
                </select>
            </div>

            <!-- Nationality -->
            <div>
                <label for="nationality" class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                <input type="text" name="kewarganegaraan" id="nationality" value="<?php echo e(old('kewarganegaraan', $patient->kewarganegaraan)); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Occupation -->
            <div>
                <label for="occupation" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                <input type="text" name="pekerjaan" id="occupation" value="<?php echo e(old('pekerjaan', $patient->pekerjaan)); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Address -->
            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700">Address *</label>
                <textarea name="alamat" id="address" rows="3" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"><?php echo e(old('alamat', $patient->alamat)); ?></textarea>
            </div>

            <!-- Emergency Contact Name -->
            <div>
                <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">Emergency Contact Name</label>
                <input type="text" name="nama_kontak_darurat" id="emergency_contact_name" value="<?php echo e(old('nama_kontak_darurat', $patient->nama_kontak_darurat)); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Emergency Contact Phone -->
            <div>
                <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">Emergency Contact Phone</label>
                <input type="text" name="telepon_kontak_darurat" id="emergency_contact_phone" value="<?php echo e(old('telepon_kontak_darurat', $patient->telepon_kontak_darurat)); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Blood Type -->
            <div>
                <label for="blood_type" class="block text-sm font-medium text-gray-700">Blood Type</label>
                <select name="golongan_darah" id="blood_type"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Blood Type</option>
                    <option value="A+" <?php echo e(old('golongan_darah', $patient->golongan_darah) == 'A+' ? 'selected' : ''); ?>>A+</option>
                    <option value="A-" <?php echo e(old('golongan_darah', $patient->golongan_darah) == 'A-' ? 'selected' : ''); ?>>A-</option>
                    <option value="B+" <?php echo e(old('golongan_darah', $patient->golongan_darah) == 'B+' ? 'selected' : ''); ?>>B+</option>
                    <option value="B-" <?php echo e(old('golongan_darah', $patient->golongan_darah) == 'B-' ? 'selected' : ''); ?>>B-</option>
                    <option value="AB+" <?php echo e(old('golongan_darah', $patient->golongan_darah) == 'AB+' ? 'selected' : ''); ?>>AB+</option>
                    <option value="AB-" <?php echo e(old('golongan_darah', $patient->golongan_darah) == 'AB-' ? 'selected' : ''); ?>>AB-</option>
                    <option value="O+" <?php echo e(old('golongan_darah', $patient->golongan_darah) == 'O+' ? 'selected' : ''); ?>>O+</option>
                    <option value="O-" <?php echo e(old('golongan_darah', $patient->golongan_darah) == 'O-' ? 'selected' : ''); ?>>O-</option>
                </select>
            </div>

            <!-- Allergies -->
            <div class="md:col-span-2">
                <label for="allergies" class="block text-sm font-medium text-gray-700">Allergies</label>
                <textarea name="alergi" id="allergies" rows="2"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"><?php echo e(old('alergi', $patient->alergi)); ?></textarea>
            </div>

            <!-- Medical History -->
            <div class="md:col-span-2">
                <label for="medical_history" class="block text-sm font-medium text-gray-700">Riwayat Penyakit/Medical History</label>
                <textarea name="medical_history" id="medical_history" rows="3"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Riwayat penyakit yang pernah diderita, operasi, dll"><?php echo e(old('medical_history', $patient->medical_history)); ?></textarea>
            </div>

            <!-- Insurance Type -->
            <div>
                <label for="insurance_type" class="block text-sm font-medium text-gray-700">Insurance Type</label>
                <select name="jenis_asuransi" id="insurance_type"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="tidak_ada" <?php echo e(old('jenis_asuransi', $patient->jenis_asuransi) == 'tidak_ada' ? 'selected' : ''); ?>>None</option>
                    <option value="bpjs" <?php echo e(old('jenis_asuransi', $patient->jenis_asuransi) == 'bpjs' ? 'selected' : ''); ?>>BPJS</option>
                    <option value="asuransi_swasta" <?php echo e(old('jenis_asuransi', $patient->jenis_asuransi) == 'asuransi_swasta' ? 'selected' : ''); ?>>Private Insurance</option>
                </select>
            </div>

            <!-- Insurance Number -->
            <div>
                <label for="insurance_number" class="block text-sm font-medium text-gray-700">Insurance Number</label>
                <input type="text" name="nomor_asuransi" id="insurance_number" value="<?php echo e(old('nomor_asuransi', $patient->nomor_asuransi)); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="aktif" <?php echo e(old('status', $patient->status) == 'aktif' ? 'selected' : ''); ?>>Active</option>
                    <option value="tidak_aktif" <?php echo e(old('status', $patient->status) == 'tidak_aktif' ? 'selected' : ''); ?>>Inactive</option>
                    <option value="meninggal" <?php echo e(old('status', $patient->status) == 'meninggal' ? 'selected' : ''); ?>>Deceased</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="<?php echo e(route('patients.show', $patient)); ?>" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Update Patient
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\rumahsakit\resources\views/patient/edit.blade.php ENDPATH**/ ?>