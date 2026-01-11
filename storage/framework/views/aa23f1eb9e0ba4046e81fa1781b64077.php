<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Room <?php echo e($room->nomor_ruangan); ?></h1>
                <p class="text-gray-600 mt-2"><?php echo e(ucfirst(str_replace('_', ' ', $room->ruangan_type))); ?> - Floor <?php echo e($room->floor); ?></p>
            </div>
            <div class="flex space-x-3">
                <a href="<?php echo e(route('rooms.edit', $room)); ?>" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit
                </a>
                <a href="<?php echo e(route('rooms.index')); ?>" 
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
                <!-- Room Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Room Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Room Number</p>
                            <p class="font-semibold text-gray-900 text-lg"><?php echo e($room->nomor_ruangan); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Type</p>
                            <p class="font-semibold text-gray-900"><?php echo e(ucfirst(str_replace('_', ' ', $room->ruangan_type))); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Floor</p>
                            <p class="font-semibold text-gray-900"><?php echo e($room->floor); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Capacity</p>
                            <p class="font-semibold text-gray-900"><?php echo e($room->kapasitas); ?> beds</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                <?php if($room->status == 'tersedia'): ?> bg-green-100 text-green-800
                                <?php elseif($room->status == 'terisi'): ?> bg-red-100 text-red-800
                                <?php else: ?> bg-orange-100 text-orange-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($room->status)); ?>

                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Available Beds</p>
                            <p class="font-semibold text-gray-900"><?php echo e($room->tempatTidurs->where('status', 'tersedia')->count()); ?> / <?php echo e($room->tempatTidurs->count()); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Pricing Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Pricing</h2>
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-lg text-center">
                        <p class="text-sm text-gray-600 mb-2">Daily Rate</p>
                        <p class="text-4xl font-bold text-indigo-900">Rp <?php echo e(number_format($room->daily_rate, 0, ',', '.')); ?></p>
                        <p class="text-sm text-gray-600 mt-2">per day</p>
                    </div>
                </div>

                <!-- Beds List -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Beds</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        <?php $__currentLoopData = $room->tempatTidurs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bed): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border rounded-lg p-3 text-center
                                <?php if($bed->status == 'tersedia'): ?> border-green-300 bg-green-50
                                <?php elseif($bed->status == 'terisi'): ?> border-red-300 bg-red-50
                                <?php else: ?> border-gray-300 bg-gray-50
                                <?php endif; ?>">
                                <p class="font-semibold text-gray-900"><?php echo e($bed->nomor_tempat_tidur); ?></p>
                                <p class="text-xs text-gray-600 mt-1"><?php echo e(ucfirst($bed->status)); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Visual -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Room Status</h2>
                    <div class="text-center">
                        <?php if($room->status == 'tersedia'): ?>
                            <div class="w-20 h-20 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="text-lg font-bold text-green-900">Tersedia</p>
                            <p class="text-sm text-gray-600 mt-1">Siap untuk rawat inap</p>
                        <?php elseif($room->status == 'terisi'): ?>
                            <div class="w-20 h-20 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <p class="text-lg font-bold text-red-900">Terisi</p>
                            <p class="text-sm text-gray-600 mt-1">Sedang digunakan</p>
                        <?php else: ?>
                            <div class="w-20 h-20 mx-auto bg-orange-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <p class="text-lg font-bold text-orange-900">Perawatan</p>
                            <p class="text-sm text-gray-600 mt-1">Sedang diperbaiki</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="<?php echo e(route('rooms.edit', $room)); ?>" 
                            class="block w-full px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition-colors">
                            Edit Room
                        </a>
                        <form action="<?php echo e(route('rooms.destroy', $room)); ?>" method="POST" 
                            onsubmit="return confirm('Are you sure you want to delete this room and all its beds?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                class="block w-full px-4 py-2 bg-red-600 text-white text-center rounded-lg hover:bg-red-700 transition-colors">
                                Delete Room
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Record Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Record Information</h2>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600">Created</p>
                            <p class="font-semibold text-gray-900"><?php echo e($room->created_at->format('d M Y, H:i')); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Last Updated</p>
                            <p class="font-semibold text-gray-900"><?php echo e($room->updated_at->format('d M Y, H:i')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\rooms\show.blade.php ENDPATH**/ ?>