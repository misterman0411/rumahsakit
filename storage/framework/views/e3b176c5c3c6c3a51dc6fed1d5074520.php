<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<!-- Queue Display Links (Front Office & Admin) -->
<?php if(auth()->user()->hasAnyRole(['front_office', 'admin'])): ?>
<div class="bg-linear-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 mb-8 text-white">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold">Queue Display System</h3>
                <p class="text-blue-100 text-sm">Monitor antrian poliklinik secara real-time</p>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
        <?php
            $departments = \App\Models\Department::orderBy('nama')->get();
        ?>
        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            // Get queue data untuk department ini
            $today_appointments = \App\Models\Appointment::where('departemen_id', $dept->id)
                ->whereDate('tanggal_janji', today())
                ->whereIn('status', ['confirmed', 'in_progress', 'check_in'])
                ->orderBy('nomor_antrian')
                ->get();
            
            $current_queue = $today_appointments->where('status', 'in_progress')->first();
            $waiting_count = $today_appointments->whereIn('status', ['confirmed', 'check_in'])->count();
            $next_queues = $today_appointments->where('status', 'check_in')->take(2);
        ?>
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20 hover:bg-white/15 transition-all">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <div class="text-sm font-medium text-blue-100">Poliklinik</div>
                    <div class="text-lg font-bold mt-1"><?php echo e($dept->nama); ?></div>
                </div>
                <a href="<?php echo e(route('queue.display', $dept->id)); ?>" target="_blank" 
                   class="text-white/80 hover:text-white transition-colors" title="Buka Display">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </a>
            </div>
            
            <?php if($current_queue): ?>
            <div class="bg-green-500/20 rounded-md px-3 py-2 mb-2 border border-green-300/30">
                <div class="text-xs text-green-100 font-medium">Sedang Dilayani</div>
                <div class="text-2xl font-bold text-white"><?php echo e($current_queue->nomor_antrian); ?></div>
                <div class="text-xs text-green-100 truncate"><?php echo e($current_queue->pasien->nama); ?></div>
            </div>
            <?php else: ?>
            <div class="bg-white/5 rounded-md px-3 py-2 mb-2 border border-white/10">
                <div class="text-xs text-blue-200">Belum Ada Antrian</div>
            </div>
            <?php endif; ?>
            
            <div class="flex items-center justify-between text-xs text-blue-100 pt-2 border-t border-white/10">
                <span>Menunggu: <strong><?php echo e($waiting_count); ?></strong></span>
                <span>Total: <strong><?php echo e($today_appointments->count()); ?></strong></span>
            </div>
            
            <?php if($next_queues->count() > 0): ?>
            <div class="mt-2 pt-2 border-t border-white/10">
                <div class="text-xs text-blue-200 mb-1">Antrian Berikutnya:</div>
                <?php $__currentLoopData = $next_queues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $next): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="text-xs text-white/80 flex items-center gap-2">
                    <span class="font-bold"><?php echo e($next->nomor_antrian); ?></span>
                    <span class="truncate"><?php echo e($next->pasien->nama); ?></span>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="mt-4 pt-4 border-t border-white/20 text-sm text-blue-100">
        💡 Tip: Buka link di tab baru untuk ditampilkan di layar TV ruang tunggu (auto-refresh setiap 10 detik)
    </div>
</div>
<?php endif; ?>

<!-- Statistics -->
<?php if(isset($stats) && count($stats) > 0): ?>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-200 hover:border-indigo-200">
        <div class="flex items-center justify-between mb-4">
            <div class="text-xs font-bold text-gray-500 uppercase tracking-wider"><?php echo e(ucwords(str_replace('_', ' ', $label))); ?></div>
            <div class="w-11 h-11 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
        <div class="text-4xl font-bold bg-linear-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            <?php echo e(strpos($label, 'revenue') !== false ? 'Rp ' . number_format($value, 0, ',', '.') : $value); ?>

        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>

<!-- Doctor Schedule -->
<?php if($role === 'doctor' && isset($appointments) && count($appointments) > 0): ?>
<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8 border border-gray-200">
    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-indigo-50 via-purple-50 to-white">
        <h3 class="text-lg font-bold text-gray-900 flex items-center">
            <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            Jadwal Hari Ini
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Pasien</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-indigo-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo e(\Carbon\Carbon::parse($apt->janjiTemu_date)->format('H:i')); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($apt->pasien->nama); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo e(ucfirst($apt->type)); ?></td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full <?php echo e($apt->status === 'completed' ? 'bg-green-100 text-green-800' : ($apt->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                            <?php echo e(ucfirst($apt->status)); ?>

                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Front Office Recent Patients -->
<?php if($role === 'front_office' && isset($recent_patients) && count($recent_patients) > 0): ?>
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-indigo-50 via-purple-50 to-white">
        <h3 class="text-lg font-bold text-gray-900 flex items-center">
            <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            Pasien Terbaru
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">No. RM</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Telepon</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $recent_patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="hover:bg-indigo-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900"><?php echo e($patient->no_rekam_medis); ?></td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900"><?php echo e($patient->nama); ?></td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($patient->telepon); ?></td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full <?php echo e($patient->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                            <?php echo e(ucfirst($patient->status)); ?>

                        </span>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Welcome Message -->
<?php if((!isset($stats) || count($stats) === 0) && 
    (!isset($appointments) || count($appointments) === 0) && 
    (!isset($recent_patients) || count($recent_patients) === 0)): ?>
<div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-200">
    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-xl shadow-indigo-200">
        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
        </svg>
    </div>
    <h3 class="text-2xl font-bold text-gray-900 mb-3">Selamat Datang di MediCare Hospital System</h3>
    <p class="text-gray-500 mb-8 text-lg">Gunakan menu di sidebar untuk navigasi ke modul yang Anda butuhkan</p>
    <div class="flex justify-center space-x-4">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-patients')): ?>
        <a href="<?php echo e(route('patients.index')); ?>" class="flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:scale-105 transition-all duration-200 font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span>Kelola Pasien</span>
        </a>
        <?php endif; ?>
        <?php if(auth()->user()->hasAnyRole(['front_office', 'admin'])): ?>
        <a href="<?php echo e(route('appointments.create')); ?>" class="flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:scale-105 transition-all duration-200 font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>Buat Appointment</span>
        </a>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<!-- Management Comprehensive Dashboard -->
<?php if($role === 'management'): ?>
<div class="space-y-6">
    <!-- Financial Overview -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-700 rounded-xl shadow-lg p-6 text-white">
        <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Financial Overview
        </h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                <div class="text-sm text-green-100">Today Revenue</div>
                <div class="text-2xl font-bold">Rp <?php echo e(number_format($stats['today_revenue'] ?? 0, 0, ',', '.')); ?></div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                <div class="text-sm text-green-100">This Month Revenue</div>
                <div class="text-2xl font-bold">Rp <?php echo e(number_format($stats['this_month_revenue'] ?? 0, 0, ',', '.')); ?></div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                <div class="text-sm text-green-100">Unpaid Invoices</div>
                <div class="text-2xl font-bold">Rp <?php echo e(number_format($stats['unpaid_invoices'] ?? 0, 0, ',', '.')); ?></div>
                <div class="text-xs text-green-200"><?php echo e($stats['unpaid_count'] ?? 0); ?> invoices</div>
            </div>
            <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20">
                <div class="text-sm text-green-100">Collection Rate</div>
                <div class="text-2xl font-bold">
                    <?php
                        $total_billed = ($stats['this_month_revenue'] ?? 0) + ($stats['unpaid_invoices'] ?? 0);
                        $rate = $total_billed > 0 ? round(($stats['this_month_revenue'] ?? 0) / $total_billed * 100) : 0;
                    ?>
                    <?php echo e($rate); ?>%
                </div>
            </div>
        </div>
    </div>

    <!-- Operational Metrics -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Patient Statistics -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Patient Statistics
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Patients</span>
                    <span class="text-2xl font-bold text-blue-600"><?php echo e($stats['total_patients'] ?? 0); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">New This Month</span>
                    <span class="text-xl font-bold text-green-600">+<?php echo e($stats['new_patients_this_month'] ?? 0); ?></span>
                </div>
            </div>
        </div>

        <!-- Staff Statistics -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Staff Overview
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Doctors</span>
                    <span class="text-2xl font-bold text-purple-600"><?php echo e($stats['total_doctors'] ?? 0); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Nurses</span>
                    <span class="text-2xl font-bold text-pink-600"><?php echo e($stats['total_nurses'] ?? 0); ?></span>
                </div>
            </div>
        </div>

        <!-- Appointments -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Appointments
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Today</span>
                    <span class="text-2xl font-bold text-indigo-600"><?php echo e($stats['today_appointments'] ?? 0); ?></span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">This Month</span>
                    <span class="text-xl font-bold text-blue-600"><?php echo e($stats['this_month_appointments'] ?? 0); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Departmental Performance -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Laboratory -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
                Laboratory
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Pending</span>
                    <span class="text-lg font-bold text-yellow-600"><?php echo e($stats['lab_pending'] ?? 0); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Completed (Month)</span>
                    <span class="text-lg font-bold text-green-600"><?php echo e($stats['lab_completed'] ?? 0); ?></span>
                </div>
            </div>
        </div>

        <!-- Radiology -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                </svg>
                Radiology
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Pending</span>
                    <span class="text-lg font-bold text-yellow-600"><?php echo e($stats['rad_pending'] ?? 0); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Completed (Month)</span>
                    <span class="text-lg font-bold text-green-600"><?php echo e($stats['rad_completed'] ?? 0); ?></span>
                </div>
            </div>
        </div>

        <!-- Pharmacy -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Pharmacy
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Pending</span>
                    <span class="text-lg font-bold text-yellow-600"><?php echo e($stats['prescriptions_pending'] ?? 0); ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Completed (Month)</span>
                    <span class="text-lg font-bold text-green-600"><?php echo e($stats['prescriptions_completed'] ?? 0); ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity (Audit Trail) -->
    <?php if(isset($appointments) && count($appointments) > 0): ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Recent Appointments (Audit Trail)
        </h3>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Date</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Patient</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Doctor</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600">Queue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $apt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm"><?php echo e($apt->tanggal_janji->format('d/m/Y H:i')); ?></td>
                        <td class="px-4 py-3 text-sm font-medium"><?php echo e($apt->pasien->nama); ?></td>
                        <td class="px-4 py-3 text-sm"><?php echo e($apt->dokter->user->nama); ?></td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                <?php if($apt->status === 'selesai'): ?> bg-green-100 text-green-800
                                <?php elseif($apt->status === 'in_progress'): ?> bg-blue-100 text-blue-800
                                <?php elseif($apt->status === 'check_in'): ?> bg-yellow-100 text-yellow-800
                                <?php else: ?> bg-gray-100 text-gray-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($apt->status)); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm"><?php echo e($apt->nomor_antrian); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\dashboard.blade.php ENDPATH**/ ?>