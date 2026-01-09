

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Stock Movements</h1>
                <p class="text-gray-600 mt-2">Riwayat pergerakan stok obat</p>
            </div>
            <?php if(auth()->user()->hasRole('pharmacist') || auth()->user()->hasRole('admin')): ?>
            <a href="<?php echo e(route('stock-movements.create')); ?>" 
               class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:shadow-lg transition-all font-semibold">
                + Record Movement
            </a>
            <?php endif; ?>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" action="<?php echo e(route('stock-movements.index')); ?>" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Obat</label>
                    <select name="obat_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Obat</option>
                        <?php $__currentLoopData = $medications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medication): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($medication->id); ?>" <?php echo e(request('obat_id') == $medication->id ? 'selected' : ''); ?>>
                            <?php echo e($medication->nama); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis</label>
                    <select name="jenis_mutasi" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Jenis</option>
                        <option value="masuk" <?php echo e(request('jenis_mutasi') == 'masuk' ? 'selected' : ''); ?>>Masuk</option>
                        <option value="keluar" <?php echo e(request('jenis_mutasi') == 'keluar' ? 'selected' : ''); ?>>Keluar</option>
                        <option value="penyesuaian" <?php echo e(request('jenis_mutasi') == 'penyesuaian' ? 'selected' : ''); ?>>Penyesuaian</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Dari Tanggal</label>
                    <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Movements Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Obat</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Jenis</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Stok Setelah</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($movement->created_at->format('d/m/Y H:i')); ?>

                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="font-semibold text-gray-900"><?php echo e($movement->obat->nama); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($movement->obat->kode); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($movement->jenis_mutasi === 'masuk'): ?>
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Masuk
                                    </span>
                                <?php elseif($movement->jenis_mutasi === 'keluar'): ?>
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Keluar
                                    </span>
                                <?php else: ?>
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                        <?php echo e(ucfirst($movement->jenis_mutasi)); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="text-sm font-bold <?php echo e($movement->jenis_mutasi === 'masuk' ? 'text-green-600' : ($movement->jenis_mutasi === 'keluar' ? 'text-red-600' : 'text-gray-900')); ?>">
                                    <?php echo e($movement->jenis_mutasi === 'masuk' ? '+' : '-'); ?><?php echo e(number_format($movement->jumlah, 0)); ?>

                                </span>
                                <span class="text-xs text-gray-500 ml-1"><?php echo e($movement->obat->satuan); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-gray-900">
                                <?php echo e(number_format($movement->stok_setelah, 0)); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?php echo e($movement->user->nama ?? '-'); ?>

                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?php echo e(Str::limit($movement->keterangan, 50) ?? '-'); ?>

                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="mt-4 text-gray-500 font-medium">Belum ada pergerakan stok</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($movements->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-200">
                <?php echo e($movements->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views/stock-movements/index.blade.php ENDPATH**/ ?>