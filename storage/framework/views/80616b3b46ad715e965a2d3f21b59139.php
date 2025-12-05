

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
                <select name="gender" id="gender" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="male" <?php echo e(old('gender', $patient->gender) == 'male' ? 'selected' : ''); ?>>Male</option>
                    <option value="female" <?php echo e(old('gender', $patient->gender) == 'female' ? 'selected' : ''); ?>>Female</option>
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
                <select name="religion" id="religion"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Agama</option>
                    <option value="islam" <?php echo e(old('religion', $patient->religion) == 'islam' ? 'selected' : ''); ?>>Islam</option>
                    <option value="kristen" <?php echo e(old('religion', $patient->religion) == 'kristen' ? 'selected' : ''); ?>>Kristen</option>
                    <option value="katolik" <?php echo e(old('religion', $patient->religion) == 'katolik' ? 'selected' : ''); ?>>Katolik</option>
                    <option value="hindu" <?php echo e(old('religion', $patient->religion) == 'hindu' ? 'selected' : ''); ?>>Hindu</option>
                    <option value="buddha" <?php echo e(old('religion', $patient->religion) == 'buddha' ? 'selected' : ''); ?>>Buddha</option>
                    <option value="konghucu" <?php echo e(old('religion', $patient->religion) == 'konghucu' ? 'selected' : ''); ?>>Konghucu</option>
                    <option value="other" <?php echo e(old('religion', $patient->religion) == 'other' ? 'selected' : ''); ?>>Lainnya</option>
                </select>
            </div>

            <!-- Marital Status -->
            <div>
                <label for="marital_status" class="block text-sm font-medium text-gray-700">Status Pernikahan</label>
                <select name="marital_status" id="marital_status"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Status</option>
                    <option value="single" <?php echo e(old('marital_status', $patient->marital_status) == 'single' ? 'selected' : ''); ?>>Belum Menikah</option>
                    <option value="married" <?php echo e(old('marital_status', $patient->marital_status) == 'married' ? 'selected' : ''); ?>>Menikah</option>
                    <option value="divorced" <?php echo e(old('marital_status', $patient->marital_status) == 'divorced' ? 'selected' : ''); ?>>Cerai</option>
                    <option value="widowed" <?php echo e(old('marital_status', $patient->marital_status) == 'widowed' ? 'selected' : ''); ?>>Duda/Janda</option>
                </select>
            </div>

            <!-- Nationality -->
            <div>
                <label for="nationality" class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                <input type="text" name="nationality" id="nationality" value="<?php echo e(old('nationality', $patient->nationality)); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Occupation -->
            <div>
                <label for="occupation" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                <input type="text" name="occupation" id="occupation" value="<?php echo e(old('occupation', $patient->occupation)); ?>"
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
                <input type="text" name="emergency_contact_name" id="emergency_contact_name" value="<?php echo e(old('emergency_contact_name', $patient->nama_kontak_darurat)); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Emergency Contact Phone -->
            <div>
                <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">Emergency Contact Phone</label>
                <input type="text" name="emergency_contact_phone" id="emergency_contact_phone" value="<?php echo e(old('emergency_contact_phone', $patient->telepon_kontak_darurat)); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Blood Type -->
            <div>
                <label for="blood_type" class="block text-sm font-medium text-gray-700">Blood Type</label>
                <select name="golongan_darah" id="blood_type"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Blood Type</option>
                    <option value="A+" <?php echo e(old('blood_type', $patient->golongan_darah) == 'A+' ? 'selected' : ''); ?>>A+</option>
                    <option value="A-" <?php echo e(old('blood_type', $patient->golongan_darah) == 'A-' ? 'selected' : ''); ?>>A-</option>
                    <option value="B+" <?php echo e(old('blood_type', $patient->golongan_darah) == 'B+' ? 'selected' : ''); ?>>B+</option>
                    <option value="B-" <?php echo e(old('blood_type', $patient->golongan_darah) == 'B-' ? 'selected' : ''); ?>>B-</option>
                    <option value="AB+" <?php echo e(old('blood_type', $patient->golongan_darah) == 'AB+' ? 'selected' : ''); ?>>AB+</option>
                    <option value="AB-" <?php echo e(old('blood_type', $patient->golongan_darah) == 'AB-' ? 'selected' : ''); ?>>AB-</option>
                    <option value="O+" <?php echo e(old('blood_type', $patient->golongan_darah) == 'O+' ? 'selected' : ''); ?>>O+</option>
                    <option value="O-" <?php echo e(old('blood_type', $patient->golongan_darah) == 'O-' ? 'selected' : ''); ?>>O-</option>
                </select>
            </div>

            <!-- Allergies -->
            <div class="md:col-span-2">
                <label for="allergies" class="block text-sm font-medium text-gray-700">Allergies</label>
                <textarea name="allergies" id="allergies" rows="2"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"><?php echo e(old('allergies', $patient->alergi)); ?></textarea>
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
                <select name="insurance_type" id="insurance_type"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="none" <?php echo e(old('insurance_type', $patient->insurance_type) == 'none' ? 'selected' : ''); ?>>None</option>
                    <option value="bpjs" <?php echo e(old('insurance_type', $patient->insurance_type) == 'bpjs' ? 'selected' : ''); ?>>BPJS</option>
                    <option value="private" <?php echo e(old('insurance_type', $patient->insurance_type) == 'private' ? 'selected' : ''); ?>>Private Insurance</option>
                </select>
            </div>

            <!-- Insurance Number -->
            <div>
                <label for="insurance_number" class="block text-sm font-medium text-gray-700">Insurance Number</label>
                <input type="text" name="insurance_number" id="insurance_number" value="<?php echo e(old('insurance_number', $patient->insurance_number)); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="active" <?php echo e(old('status', $patient->status) == 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="inactive" <?php echo e(old('status', $patient->status) == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                    <option value="deceased" <?php echo e(old('status', $patient->status) == 'deceased' ? 'selected' : ''); ?>>Deceased</option>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rs\hospital-management-system\resources\views/patients/edit.blade.php ENDPATH**/ ?>