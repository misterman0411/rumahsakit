<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800"><?php echo e($medication->nama); ?></h1>
                <p class="text-gray-600 mt-2"><?php echo e($medication->kode); ?></p>
            </div>
            <div class="flex space-x-3">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-medications')): ?>
                <a href="<?php echo e(route('medications.edit', $medication)); ?>" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit
                </a>
                <?php endif; ?>
                <a href="<?php echo e(route('medications.index')); ?>" 
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to List
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Basic Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Medication Name</p>
                            <p class="font-semibold text-gray-900"><?php echo e($medication->nama); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kode Obat</p>
                            <p class="font-semibold text-gray-900"><?php echo e($medication->kode); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Bentuk Sediaan</p>
                            <p class="font-semibold text-gray-900"><?php echo e($medication->bentuk_sediaan); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kekuatan</p>
                            <p class="font-semibold text-gray-900"><?php echo e($medication->kekuatan); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Satuan</p>
                            <p class="font-semibold text-gray-900"><?php echo e($medication->satuan); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Kategori</p>
                            <p class="font-semibold text-gray-900"><?php echo e($medication->kategori ?? '-'); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Stock & Pricing -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Stock & Pricing</h2>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm text-blue-900 mb-1">Harga Satuan</p>
                            <p class="text-2xl font-bold text-blue-900">Rp <?php echo e(number_format($medication->harga, 0, ',', '.')); ?></p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-sm text-green-900 mb-1">Stok Tersedia</p>
                            <p class="text-2xl font-bold text-green-900"><?php echo e($medication->stok); ?> <?php echo e($medication->satuan); ?></p>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <p class="text-sm text-orange-900 mb-1">Stok Minimum</p>
                            <p class="text-2xl font-bold text-orange-900"><?php echo e($medication->stok_minimum ?? 0); ?> <?php echo e($medication->satuan); ?></p>
                        </div>
                    </div>
                    
                    <?php if($medication->stok <= $medication->stok_minimum): ?>
                        <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="font-semibold text-red-900">Low Stock Alert!</span>
                            </div>
                            <p class="text-sm text-red-700 mt-1">Stock is below minimum level. Please reorder.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Description -->
                <?php if($medication->deskripsi): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Deskripsi</h2>
                    <p class="text-gray-700 whitespace-pre-wrap"><?php echo e($medication->deskripsi); ?></p>
                </div>
                <?php endif; ?>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Expiry Info -->
                <?php if($medication->tanggal_kadaluarsa): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Kadaluarsa</h2>
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Tanggal Kadaluarsa</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2"><?php echo e(\Carbon\Carbon::parse($medication->tanggal_kadaluarsa)->format('d M Y')); ?></p>
                        <?php
                            $daysUntilExpiry = now()->diffInDays($medication->tanggal_kadaluarsa, false);
                        ?>
                        <?php if($daysUntilExpiry < 0): ?>
                            <span class="inline-block mt-2 px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                Expired <?php echo e(abs($daysUntilExpiry)); ?> days ago
                            </span>
                        <?php elseif($daysUntilExpiry <= 30): ?>
                            <span class="inline-block mt-2 px-3 py-1 bg-orange-100 text-orange-800 text-xs font-semibold rounded-full">
                                Expires in <?php echo e($daysUntilExpiry); ?> days
                            </span>
                        <?php else: ?>
                            <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                <?php echo e($daysUntilExpiry); ?> days remaining
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Quick Actions -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-medications')): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="<?php echo e(route('medications.edit', $medication)); ?>" 
                            class="block w-full px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition-colors">
                            Edit Medication
                        </a>
                        <form action="<?php echo e(route('medications.destroy', $medication)); ?>" method="POST" 
                            onsubmit="return confirm('Are you sure you want to delete this medication?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                class="block w-full px-4 py-2 bg-red-600 text-white text-center rounded-lg hover:bg-red-700 transition-colors">
                                Delete Medication
                            </button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Record Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Record Information</h2>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600">Created</p>
                            <p class="font-semibold text-gray-900"><?php echo e($medication->created_at->format('d M Y, H:i')); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Last Updated</p>
                            <p class="font-semibold text-gray-900"><?php echo e($medication->updated_at->format('d M Y, H:i')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\medications\show.blade.php ENDPATH**/ ?>