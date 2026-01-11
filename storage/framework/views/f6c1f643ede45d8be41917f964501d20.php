<?php $__env->startSection('title', 'Create Appointment'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800">Create New Appointment</h2>
    </div>

    <form action="<?php echo e(route('appointments.store')); ?>" method="POST" class="p-6">
        <?php echo csrf_field(); ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Patient -->
            <div class="md:col-span-2">
                <label for="pasien_id" class="block text-sm font-medium text-gray-700">Patient *</label>
                <select name="pasien_id" id="pasien_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Patient</option>
                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($patient->id); ?>" <?php echo e(old('pasien_id', request('patient_id')) == $patient->id ? 'selected' : ''); ?>>
                            <?php echo e($patient->no_rekam_medis); ?> - <?php echo e($patient->nama); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Doctor -->
            <div class="md:col-span-2">
                <label for="dokter_id" class="block text-sm font-medium text-gray-700">Doctor *</label>
                <select name="dokter_id" id="dokter_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Doctor</option>
                    <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($doctor->id); ?>" <?php echo e(old('dokter_id') == $doctor->id ? 'selected' : ''); ?>>
                            <?php echo e($doctor->user->nama); ?> - <?php echo e($doctor->departemen->nama); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <!-- Appointment Date & Time -->
            <div>
                <label for="tanggal_janji" class="block text-sm font-medium text-gray-700">Tanggal *</label>
                <input type="date" name="tanggal_janji" id="tanggal_janji" required value="<?php echo e(old('tanggal_janji')); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="waktu_janji" class="block text-sm font-medium text-gray-700">Waktu *</label>
                <input type="time" name="waktu_janji" id="waktu_janji" required value="<?php echo e(old('waktu_janji')); ?>"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Appointment Type -->
            <div>
                <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis *</label>
                <select name="jenis" id="jenis" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Jenis</option>
                    <option value="rawat_jalan" <?php echo e(old('jenis') == 'rawat_jalan' ? 'selected' : ''); ?>>Rawat Jalan</option>
                    <option value="kontrol_ulang" <?php echo e(old('jenis') == 'kontrol_ulang' ? 'selected' : ''); ?>>Kontrol Ulang</option>
                    <option value="darurat" <?php echo e(old('jenis') == 'darurat' ? 'selected' : ''); ?>>Darurat</option>
                    <option value="rawat_inap" <?php echo e(old('jenis') == 'rawat_inap' ? 'selected' : ''); ?>>Rawat Inap</option>
                </select>
            </div>

            <!-- Reason -->
            <div class="md:col-span-2">
                <label for="alasan" class="block text-sm font-medium text-gray-700">Alasan Kunjungan *</label>
                <textarea name="alasan" id="alasan" rows="3" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"><?php echo e(old('alasan')); ?></textarea>
            </div>

            <!-- Notes -->
            <div class="md:col-span-2">
                <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea name="catatan" id="catatan" rows="2"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"><?php echo e(old('catatan')); ?></textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="<?php echo e(route('appointments.index')); ?>" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Create Appointment
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\rumahsakit\resources\views/appointments/create.blade.php ENDPATH**/ ?>