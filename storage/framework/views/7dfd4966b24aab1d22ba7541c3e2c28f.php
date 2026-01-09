<?php $__env->startSection('title', 'Patient Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Patient Info Card -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Patient Details</h2>
            <div class="flex space-x-2">
                <?php if(auth()->user()->hasAnyRole(['front_office', 'admin'])): ?>
                <a href="<?php echo e(route('patients.edit', $patient)); ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                    Edit
                </a>
                <a href="<?php echo e(route('appointments.create', ['patient_id' => $patient->id])); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    New Appointment
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="text-sm font-medium text-gray-500">MRN</label>
                <p class="mt-1 text-lg text-gray-900"><?php echo e($patient->no_rekam_medis); ?></p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Full Name</label>
                <p class="mt-1 text-lg text-gray-900"><?php echo e($patient->nama); ?></p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Date of Birth</label>
                <p class="mt-1 text-gray-900"><?php echo e($patient->tanggal_lahir->format('d M Y')); ?> (<?php echo e($patient->tanggal_lahir->age); ?> years)</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Gender</label>
                <p class="mt-1 text-gray-900"><?php echo e(ucfirst($patient->gender)); ?></p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Phone</label>
                <p class="mt-1 text-gray-900"><?php echo e($patient->telepon); ?></p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Email</label>
                <p class="mt-1 text-gray-900"><?php echo e($patient->email ?: 'N/A'); ?></p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">ID Number</label>
                <p class="mt-1 text-gray-900"><?php echo e($patient->no_identitas); ?></p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Blood Type</label>
                <p class="mt-1 text-gray-900"><?php echo e($patient->golongan_darah ?: 'N/A'); ?></p>
            </div>
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-500">Address</label>
                <p class="mt-1 text-gray-900"><?php echo e($patient->alamat); ?></p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Emergency Contact Name</label>
                <p class="mt-1 text-gray-900"><?php echo e($patient->nama_kontak_darurat ?: 'N/A'); ?></p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Emergency Contact Phone</label>
                <p class="mt-1 text-gray-900"><?php echo e($patient->telepon_kontak_darurat ?: 'N/A'); ?></p>
            </div>
            <div class="md:col-span-2">
                <label class="text-sm font-medium text-gray-500">Allergies</label>
                <p class="mt-1 text-gray-900"><?php echo e($patient->alergi ?: 'None'); ?></p>
            </div>
        </div>
    </div>

    <!-- Recent Appointments -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800">Recent Appointments</h3>
        </div>
        <div class="p-6">
            <?php if($patient->janjiTemu->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date & Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Doctor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $patient->janjiTemu->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($appointment->tanggal_janji->format('d M Y H:i')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($appointment->dokter->user->nama); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e(ucfirst(str_replace('_', ' ', $appointment->jenis))); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    <?php if($appointment->status == 'selesai'): ?> bg-green-100 text-green-800
                                    <?php elseif($appointment->status == 'dibatalkan'): ?> bg-red-100 text-red-800
                                    <?php else: ?> bg-yellow-100 text-yellow-800 <?php endif; ?>">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $appointment->status))); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="<?php echo e(route('appointments.show', $appointment)); ?>" class="text-blue-600 hover:text-blue-900">View</a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <p class="text-gray-500">No appointments yet</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views/patients/show.blade.php ENDPATH**/ ?>