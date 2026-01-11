

<?php $__env->startSection('title', 'Dashboard Pasien'); ?>
<?php $__env->startSection('subtitle', 'Ringkasan informasi kesehatan Anda'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Upcoming</span>
        </div>
        <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['upcoming_appointments']); ?></p>
        <p class="text-sm text-gray-500 mt-1">Janji Temu Mendatang</p>
    </div>

    <div class="stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">Completed</span>
        </div>
        <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['total_visits']); ?></p>
        <p class="text-sm text-gray-500 mt-1">Total Kunjungan</p>
    </div>

    <div class="stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['total_prescriptions']); ?></p>
        <p class="text-sm text-gray-500 mt-1">Total Resep</p>
    </div>

    <div class="stat-card">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
            <?php if($stats['pending_invoices'] > 0): ?>
                <span class="text-xs font-semibold text-orange-600 bg-orange-50 px-2 py-1 rounded-full">Pending</span>
            <?php endif; ?>
        </div>
        <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['pending_invoices']); ?></p>
        <p class="text-sm text-gray-500 mt-1">Tagihan Belum Bayar</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Quick Actions -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-6 text-white">
            <h3 class="text-lg font-bold mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <a href="<?php echo e(route('patient.appointments.book')); ?>" class="bg-white/20 hover:bg-white/30 backdrop-blur rounded-xl p-4 text-center transition-all hover:scale-105">
                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="text-sm font-medium">Booking Baru</span>
                </a>
                <a href="<?php echo e(route('patient.medical-records')); ?>" class="bg-white/20 hover:bg-white/30 backdrop-blur rounded-xl p-4 text-center transition-all hover:scale-105">
                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="text-sm font-medium">Rekam Medis</span>
                </a>
                <a href="<?php echo e(route('patient.invoices')); ?>" class="bg-white/20 hover:bg-white/30 backdrop-blur rounded-xl p-4 text-center transition-all hover:scale-105">
                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <span class="text-sm font-medium">Tagihan</span>
                </a>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">Janji Temu Mendatang</h3>
                <a href="<?php echo e(route('patient.appointments')); ?>" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat Semua →</a>
            </div>
            <div class="p-6">
                <?php if($upcomingAppointments->count() > 0): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $upcomingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-indigo-50 transition-colors">
                                <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex flex-col items-center justify-center text-white mr-4">
                                    <span class="text-xs font-medium"><?php echo e(\Carbon\Carbon::parse($appointment->tanggal_janji)->format('M')); ?></span>
                                    <span class="text-lg font-bold"><?php echo e(\Carbon\Carbon::parse($appointment->tanggal_janji)->format('d')); ?></span>
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900"><?php echo e($appointment->dokter->user->nama ?? 'Dokter'); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo e($appointment->departemen->nama ?? 'Poliklinik'); ?> • <?php echo e(\Carbon\Carbon::parse($appointment->tanggal_janji)->format('H:i')); ?></p>
                                </div>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    <?php if($appointment->status === 'dikonfirmasi'): ?> bg-green-100 text-green-700
                                    <?php elseif($appointment->status === 'terjadwal'): ?> bg-yellow-100 text-yellow-700
                                    <?php else: ?> bg-gray-100 text-gray-700
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $appointment->status))); ?>

                                </span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-gray-500 mb-4">Belum ada janji temu</p>
                        <a href="<?php echo e(route('patient.appointments.book')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Buat Janji Temu
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-8">
        <!-- Patient Info -->
        <?php if($patient): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Pasien</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">No. Rekam Medis</span>
                        <span class="text-sm font-semibold text-gray-900"><?php echo e($patient->no_rekam_medis); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Nama</span>
                        <span class="text-sm font-semibold text-gray-900"><?php echo e($patient->nama); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Tanggal Lahir</span>
                        <span class="text-sm font-semibold text-gray-900"><?php echo e($patient->tanggal_lahir ? $patient->tanggal_lahir->format('d M Y') : '-'); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Golongan Darah</span>
                        <span class="text-sm font-semibold text-gray-900"><?php echo e($patient->golongan_darah ?? '-'); ?></span>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h4 class="font-semibold text-yellow-800">Data Pasien Belum Terdaftar</h4>
                        <p class="text-sm text-yellow-700 mt-1">Silakan hubungi bagian pendaftaran untuk mendaftarkan data pasien Anda.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Recent Prescriptions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900">Resep Terbaru</h3>
                <a href="<?php echo e(route('patient.prescriptions')); ?>" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat →</a>
            </div>
            <div class="p-6">
                <?php if($activePrescriptions->count() > 0): ?>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $activePrescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm font-semibold text-gray-900"><?php echo e($prescription->dokter->user->nama ?? 'Dokter'); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($prescription->created_at->format('d M Y')); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <p class="text-sm text-gray-500 text-center py-4">Belum ada resep</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.patient', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\rumahsakit\resources\views/patient/dashboard.blade.php ENDPATH**/ ?>