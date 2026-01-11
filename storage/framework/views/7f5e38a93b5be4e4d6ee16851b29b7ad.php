<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Rekam Medis</h1>
                <p class="text-gray-600 mt-2">ID: <?php echo e($medicalRecord->id); ?></p>
            </div>
            <?php if(auth()->user()->hasAnyRole(['doctor', 'admin'])): ?>
            <a href="<?php echo e(route('medical-records.edit', $medicalRecord)); ?>"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Edit
            </a>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Pemeriksaan</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Pemeriksaan</p>
                            <p class="font-semibold"><?php echo e($medicalRecord->created_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <?php if($medicalRecord->janjiTemu): ?>
                        <div>
                            <p class="text-sm text-gray-500">Appointment</p>
                            <p class="font-semibold"><?php echo e($medicalRecord->janjiTemu->nomor_janji_temu); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Chief Complaint -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-3">Keluhan Utama</h2>
                    <p class="text-gray-800"><?php echo e($medicalRecord->keluhan); ?></p>
                </div>

                <!-- Vital Signs -->
                <?php if($medicalRecord->tanda_vital): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Tanda-Tanda Vital</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <?php if(isset($medicalRecord->tanda_vital['blood_pressure'])): ?>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">Tekanan Darah</p>
                            <p class="text-lg font-bold text-gray-800"><?php echo e($medicalRecord->tanda_vital['blood_pressure']); ?> <span class="text-sm font-normal">mmHg</span></p>
                        </div>
                        <?php endif; ?>
                        <?php if(isset($medicalRecord->tanda_vital['temperature'])): ?>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">Suhu</p>
                            <p class="text-lg font-bold text-gray-800"><?php echo e($medicalRecord->tanda_vital['temperature']); ?> <span class="text-sm font-normal">°C</span></p>
                        </div>
                        <?php endif; ?>
                        <?php if(isset($medicalRecord->tanda_vital['heart_rate'])): ?>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">Nadi</p>
                            <p class="text-lg font-bold text-gray-800"><?php echo e($medicalRecord->tanda_vital['heart_rate']); ?> <span class="text-sm font-normal">bpm</span></p>
                        </div>
                        <?php endif; ?>
                        <?php if(isset($medicalRecord->tanda_vital['respiratory_rate'])): ?>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">Pernapasan</p>
                            <p class="text-lg font-bold text-gray-800"><?php echo e($medicalRecord->tanda_vital['respiratory_rate']); ?> <span class="text-sm font-normal">/menit</span></p>
                        </div>
                        <?php endif; ?>
                        <?php if(isset($medicalRecord->tanda_vital['oxygen_saturation'])): ?>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">SpO2</p>
                            <p class="text-lg font-bold text-gray-800"><?php echo e($medicalRecord->tanda_vital['oxygen_saturation']); ?> <span class="text-sm font-normal">%</span></p>
                        </div>
                        <?php endif; ?>
                        <?php if(isset($medicalRecord->tanda_vital['weight'])): ?>
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">Berat Badan</p>
                            <p class="text-lg font-bold text-gray-800"><?php echo e($medicalRecord->tanda_vital['weight']); ?> <span class="text-sm font-normal">kg</span></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Diagnosis -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-3">Diagnosis</h2>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-gray-800 font-semibold"><?php echo e($medicalRecord->diagnosis); ?></p>
                    </div>
                </div>

                <!-- Treatment Plan -->
                <?php if($medicalRecord->rencana_perawatan): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-3">Rencana Tindakan</h2>
                    <p class="text-gray-800"><?php echo e($medicalRecord->rencana_perawatan); ?></p>
                </div>
                <?php endif; ?>

                <!-- Notes -->
                <?php if($medicalRecord->catatan): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-3">Catatan Tambahan</h2>
                    <p class="text-gray-800"><?php echo e($medicalRecord->catatan); ?></p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Patient Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Pasien</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">No. RM</p>
                            <p class="font-semibold"><?php echo e($medicalRecord->pasien->no_rekam_medis); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold"><?php echo e($medicalRecord->pasien->nama); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jenis Kelamin</p>
                            <p><?php echo e($medicalRecord->pasien->jenis_kelamin === 'laki_laki' ? 'Laki-laki' : 'Perempuan'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Lahir</p>
                            <p><?php echo e(\Carbon\Carbon::parse($medicalRecord->pasien->tanggal_lahir)->format('d/m/Y')); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Golongan Darah</p>
                            <p><?php echo e($medicalRecord->pasien->golongan_darah ?? '-'); ?></p>
                        </div>
                        <?php if($medicalRecord->pasien->alergi): ?>
                        <div class="mt-3 bg-red-50 p-3 rounded-lg">
                            <p class="text-xs text-red-600 font-semibold mb-1">ALERGI:</p>
                            <p class="text-sm text-red-800"><?php echo e($medicalRecord->pasien->alergi); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo e(route('patients.show', $medicalRecord->pasien)); ?>"
                        class="block w-full text-center px-4 py-2 mt-4 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        Lihat Detail Pasien
                    </a>
                </div>

                <!-- Doctor Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Dokter Pemeriksa</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold"><?php echo e($medicalRecord->dokter->user->nama); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Spesialisasi</p>
                            <p><?php echo e($medicalRecord->dokter->spesialisasi); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">No. Lisensi</p>
                            <p class="text-sm"><?php echo e($medicalRecord->dokter->nomor_lisensi); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\medical-records\show.blade.php ENDPATH**/ ?>