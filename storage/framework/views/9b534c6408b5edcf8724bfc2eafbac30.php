<?php $__env->startSection('title', 'Appointments'); ?>

<?php $__env->startSection('content'); ?>
<!-- Filter & Search -->
<div class="bg-white rounded-xl shadow-md mb-6 border border-gray-100">
    <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-white">
        <h3 class="text-lg font-bold text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Search & Filter
        </h3>
    </div>
    <div class="p-8">
        <form method="GET" action="<?php echo e(route('appointments.index')); ?>">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Cari Appointment</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" id="search" name="search" 
                               value="<?php echo e(request('search')); ?>"
                               class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                               placeholder="No. Appointment, Nama Pasien, atau Nama Dokter">
                    </div>
                </div>
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select id="status" name="status" class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="">Semua Status</option>
                        <option value="scheduled" <?php echo e(request('status') === 'scheduled' ? 'selected' : ''); ?>>Terjadwal</option>
                        <option value="confirmed" <?php echo e(request('status') === 'confirmed' ? 'selected' : ''); ?>>Dikonfirmasi</option>
                        <option value="in_progress" <?php echo e(request('status') === 'in_progress' ? 'selected' : ''); ?>>Sedang Berjalan</option>
                        <option value="completed" <?php echo e(request('status') === 'completed' ? 'selected' : ''); ?>>Selesai</option>
                        <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Dibatalkan</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari
                    </button>
                    <?php if(request('search') || request('status')): ?>
                    <a href="<?php echo e(route('appointments.index')); ?>" class="inline-flex items-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors">
                        Reset
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Appointment List -->
<div class="bg-white rounded-xl shadow-md border border-gray-100">
    <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">Daftar Appointment</h3>
                <p class="text-sm text-gray-500 mt-1">Manage patient appointments and schedules</p>
            </div>
            <?php if(auth()->user()->hasAnyRole(['front_office', 'admin'])): ?>
            <a href="<?php echo e(route('appointments.create')); ?>" class="flex items-center space-x-2 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all duration-200 font-semibold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span>Buat Appointment</span>
            </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="p-8">
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">No. Appointment</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Pasien</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Dokter</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tanggal & Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-blue-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-bold text-blue-600"><?php echo e($appointment->nomor_janji_temu); ?></span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                    <?php echo e(strtoupper(substr($appointment->pasien->nama, 0, 1))); ?>

                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-gray-900"><?php echo e($appointment->pasien->nama); ?></div>
                                    <div class="text-xs text-gray-500"><?php echo e($appointment->pasien->no_rekam_medis); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900"><?php echo e($appointment->dokter->user->nama ?? 'N/A'); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e($appointment->dokter->spesialisasi ?? '-'); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900"><?php echo e(\Carbon\Carbon::parse($appointment->tanggal_janji)->format('d M Y')); ?></div>
                            <div class="text-xs text-gray-500"><?php echo e(\Carbon\Carbon::parse($appointment->tanggal_janji)->format('H:i')); ?> WIB</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                                $typeLabels = [
                                    'outpatient' => 'Rawat Jalan',
                                    'emergency' => 'IGD',
                                    'inpatient' => 'Rawat Inap',
                                    'follow_up' => 'Follow Up',
                                ];
                                $typeColors = [
                                    'outpatient' => 'bg-blue-100 text-blue-800',
                                    'emergency' => 'bg-red-100 text-red-800',
                                    'inpatient' => 'bg-purple-100 text-purple-800',
                                    'follow_up' => 'bg-green-100 text-green-800',
                                ];
                            ?>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full <?php echo e($typeColors[$appointment->type] ?? 'bg-gray-100 text-gray-800'); ?>">
                                <?php echo e($typeLabels[$appointment->type] ?? ucfirst($appointment->type)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php
                                    $statusColors = [
                                        'scheduled' => 'bg-blue-100 text-blue-800',
                                        'confirmed' => 'bg-green-100 text-green-800',
                                        'in_progress' => 'bg-yellow-100 text-yellow-800',
                                        'completed' => 'bg-gray-100 text-gray-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'no_show' => 'bg-red-100 text-red-800',
                                    ];
                                    $statusLabels = [
                                        'scheduled' => 'Terjadwal',
                                        'confirmed' => 'Dikonfirmasi',
                                        'in_progress' => 'Berjalan',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                        'no_show' => 'Tidak Hadir',
                                    ];
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($statusColors[$appointment->status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                    <?php echo e($statusLabels[$appointment->status] ?? ucfirst($appointment->status)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <a href="<?php echo e(route('appointments.show', $appointment)); ?>" class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <?php if(auth()->user()->hasAnyRole(['front_office', 'doctor', 'admin'])): ?>
                                    <?php if($appointment->status !== 'completed' && $appointment->status !== 'cancelled'): ?>
                                    <a href="<?php echo e(route('appointments.edit', $appointment)); ?>" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <?php endif; ?>
                                    <?php if($appointment->status === 'scheduled'): ?>
                                    <form method="POST" action="<?php echo e(route('appointments.confirm', $appointment)); ?>" class="inline" onsubmit="return confirm('Konfirmasi appointment ini?')">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="text-green-600 hover:text-green-900" title="Konfirmasi">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    <?php if($appointment->status !== 'completed' && $appointment->status !== 'cancelled'): ?>
                                    <form method="POST" action="<?php echo e(route('appointments.cancel', $appointment)); ?>" class="inline" onsubmit="return confirm('Batalkan appointment ini?')">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Batalkan">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-gray-500 text-lg font-medium">Belum ada appointment</p>
                                    <p class="text-gray-400 text-sm mt-1">Klik tombol "Buat Appointment" untuk menambah data</p>
                                    <a href="<?php echo e(route('appointments.create')); ?>" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition-colors duration-150">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Buat Appointment
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if($appointments->hasPages()): ?>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menampilkan <span class="font-medium"><?php echo e($appointments->firstItem()); ?></span> sampai <span class="font-medium"><?php echo e($appointments->lastItem()); ?></span> dari <span class="font-medium"><?php echo e($appointments->total()); ?></span> data
                    </div>
                    <div>
                        <?php echo e($appointments->links()); ?>

                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\appointments\index.blade.php ENDPATH**/ ?>