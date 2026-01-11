

<?php $__env->startSection('title', 'Dashboard Pasien'); ?>
<?php $__env->startSection('subtitle', 'Ringkasan informasi kesehatan Anda'); ?>

<?php $__env->startSection('content'); ?>
<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Upcoming Appointments -->
    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-200 hover:border-indigo-200">
        <div class="flex items-center justify-between mb-4">
            <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Upcoming</div>
            <div class="w-11 h-11 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>
        <div class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
            <?php echo e($stats['upcoming_appointments']); ?>

        </div>
        <div class="text-sm text-gray-500 mt-1">Janji Temu Mendatang</div>
    </div>

    <!-- Total Visits -->
    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-200 hover:border-green-200">
        <div class="flex items-center justify-between mb-4">
            <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Completed</div>
            <div class="w-11 h-11 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg shadow-green-200 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
            <?php echo e($stats['total_visits']); ?>

        </div>
        <div class="text-sm text-gray-500 mt-1">Total Kunjungan</div>
    </div>

    <!-- Prescriptions -->
    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-200 hover:border-purple-200">
        <div class="flex items-center justify-between mb-4">
            <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Prescriptions</div>
            <div class="w-11 h-11 bg-gradient-to-br from-purple-500 to-fuchsia-600 rounded-xl flex items-center justify-center shadow-lg shadow-purple-200 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
            </div>
        </div>
        <div class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-fuchsia-600 bg-clip-text text-transparent">
            <?php echo e($stats['total_prescriptions']); ?>

        </div>
        <div class="text-sm text-gray-500 mt-1">Total Resep</div>
    </div>

    <!-- Invoices -->
    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-200 hover:border-orange-200">
        <div class="flex items-center justify-between mb-4">
            <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Unpaid</div>
            <div class="w-11 h-11 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg shadow-orange-200 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
            </div>
        </div>
        <div class="text-4xl font-bold bg-gradient-to-r from-orange-600 to-red-600 bg-clip-text text-transparent">
            <?php echo e($stats['pending_invoices']); ?>

        </div>
        <div class="text-sm text-gray-500 mt-1 bg-red-50 text-red-600 px-2 rounded-md inline-block">Tagihan Belum Bayar</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Quick Actions -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white shadow-xl shadow-indigo-200">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-2xl font-bold mb-2">Aksi Cepat</h3>
                    <p class="text-indigo-100">Akses cepat ke menu yang sering Anda gunakan</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                <a href="<?php echo e(route('patient.appointments.book')); ?>" class="group bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/10 rounded-xl p-4 text-center transition-all hover:scale-105">
                    <div class="w-10 h-10 mx-auto mb-3 bg-white/20 rounded-lg flex items-center justify-center group-hover:rotate-6 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium">Booking Baru</span>
                </a>
                <a href="<?php echo e(route('patient.medical-records')); ?>" class="group bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/10 rounded-xl p-4 text-center transition-all hover:scale-105">
                    <div class="w-10 h-10 mx-auto mb-3 bg-white/20 rounded-lg flex items-center justify-center group-hover:rotate-6 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium">Rekam Medis</span>
                </a>
                <a href="<?php echo e(route('patient.invoices')); ?>" class="group bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/10 rounded-xl p-4 text-center transition-all hover:scale-105">
                    <div class="w-10 h-10 mx-auto mb-3 bg-white/20 rounded-lg flex items-center justify-center group-hover:rotate-6 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium">Tagihan</span>
                </a>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Janji Temu Mendatang
                </h3>
                <a href="<?php echo e(route('patient.appointments')); ?>" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-1">
                    Lihat Semua 
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
            <div class="p-6">
                <?php if($upcomingAppointments->count() > 0): ?>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $upcomingAppointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center p-4 bg-white border border-gray-100 rounded-xl hover:shadow-md hover:border-indigo-100 transition-all">
                                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex flex-col items-center justify-center text-white mr-5 shadow-sm">
                                    <span class="text-xs font-medium uppercase tracking-wider"><?php echo e(\Carbon\Carbon::parse($appointment->tanggal_janji)->format('M')); ?></span>
                                    <span class="text-2xl font-bold"><?php echo e(\Carbon\Carbon::parse($appointment->tanggal_janji)->format('d')); ?></span>
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-lg"><?php echo e($appointment->dokter->user->nama ?? 'Dokter'); ?></h4>
                                    <div class="flex items-center text-gray-500 mt-1 space-x-3 text-sm">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            <?php echo e($appointment->departemen->nama ?? 'Poliklinik'); ?>

                                        </span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <?php echo e(\Carbon\Carbon::parse($appointment->tanggal_janji)->format('H:i')); ?>

                                        </span>
                                    </div>
                                </div>
                                <span class="px-4 py-1.5 text-xs font-bold rounded-full 
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
                    <div class="text-center py-10 bg-gray-50 rounded-xl border-dashed border-2 border-gray-200">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h4 class="text-gray-900 font-medium mb-2">Belum ada janji temu</h4>
                        <p class="text-gray-500 mb-6 text-sm">Jadwalkan konsultasi dengan dokter kami sekarang</p>
                        <a href="<?php echo e(route('patient.appointments.book')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">
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
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Pasien
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                            <span class="text-sm text-gray-500">No. Rekam Medis</span>
                            <span class="text-sm font-bold text-indigo-700 bg-indigo-50 px-2 py-1 rounded"><?php echo e($patient->no_rekam_medis); ?></span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                            <span class="text-sm text-gray-500">Nama Lengkap</span>
                            <span class="text-sm font-semibold text-gray-900"><?php echo e($patient->nama); ?></span>
                        </div>
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                            <span class="text-sm text-gray-500">Tanggal Lahir</span>
                            <span class="text-sm font-semibold text-gray-900"><?php echo e($patient->tanggal_lahir ? $patient->tanggal_lahir->format('d M Y') : '-'); ?></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-500">Golongan Darah</span>
                            <span class="text-sm font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full"><?php echo e($patient->golongan_darah ?? '-'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 shadow-sm">
                <div class="flex items-start space-x-3">
                    <svg class="w-6 h-6 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <div>
                        <h4 class="font-bold text-yellow-800">Data Pasien Belum Terdaftar</h4>
                        <p class="text-sm text-yellow-700 mt-1">Silakan hubungi bagian pendaftaran untuk mendaftarkan data pasien Anda.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Recent Prescriptions -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gray-50 flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Resep Terbaru
                </h3>
                <a href="<?php echo e(route('patient.prescriptions')); ?>" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">Lihat →</a>
            </div>
            <div class="p-6">
                <?php if($activePrescriptions->count() > 0): ?>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $activePrescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-100 hover:bg-purple-50 hover:border-purple-100 transition-colors">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider"><?php echo e($prescription->created_at->format('d M Y')); ?></span>
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                </div>
                                <p class="text-sm font-bold text-gray-900 mb-1"><?php echo e($prescription->dokter->user->nama ?? 'Dokter'); ?></p>
                                <p class="text-xs text-gray-500 truncate">No. Resep: #<?php echo e($prescription->id); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-6">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">Belum ada resep</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.patient', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\laragon\www\rumahsakit\resources\views/patient/dashboard.blade.php ENDPATH**/ ?>