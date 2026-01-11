<?php $__env->startSection('title', 'Queue Display'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900">
    <!-- Header -->
    <div class="bg-white shadow-lg py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-600 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900"><?php echo e($department->nama); ?></h1>
                        <p class="text-gray-600">Antrian Poliklinik</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-4xl font-bold text-blue-600" id="current-time"></div>
                    <div class="text-gray-600" id="current-date"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Current Queue - Large Display -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-2xl p-12">
                    <div class="text-center">
                        <p class="text-2xl text-gray-600 mb-4">Sekarang Melayani</p>
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-3xl py-16 px-8 mb-6 animate-pulse">
                            <div class="text-9xl font-black" id="current-queue">
                                <?php echo e($currentQueue ? $currentQueue->queue_code : '---'); ?>

                            </div>
                        </div>
                        <?php if($currentQueue): ?>
                        <div class="text-3xl text-gray-700 font-semibold">
                            <?php echo e($currentQueue->pasien->nama); ?>

                        </div>
                        <div class="text-xl text-gray-500 mt-2">
                            Dr. <?php echo e($currentQueue->dokter->user->nama); ?>

                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Waiting List -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Antrian Selanjutnya
                    </h2>
                    <div class="space-y-3 max-h-[600px] overflow-y-auto">
                        <?php $__empty_1 = true; $__currentLoopData = $waitingQueue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $queue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-center">
                                <div>
                                    <div class="text-3xl font-bold text-blue-600"><?php echo e($queue->queue_code); ?></div>
                                    <div class="text-sm text-gray-600 mt-1"><?php echo e(Str::limit($queue->pasien->nama, 20)); ?></div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        Antrian #<?php echo e($index + 2); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-8 text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Tidak ada antrian</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Antrian</p>
                        <p class="text-3xl font-bold text-gray-900"><?php echo e($totalToday); ?></p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Sedang Dilayani</p>
                        <p class="text-3xl font-bold text-green-600"><?php echo e($currentQueue ? 1 : 0); ?></p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Menunggu</p>
                        <p class="text-3xl font-bold text-yellow-600"><?php echo e($waitingQueue->count()); ?></p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Selesai</p>
                        <p class="text-3xl font-bold text-gray-600"><?php echo e($completedToday); ?></p>
                    </div>
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Update clock
    function updateClock() {
        const now = new Date();
        const timeOptions = { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
        const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        
        document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID', timeOptions);
        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions);
    }

    updateClock();
    setInterval(updateClock, 1000);

    // Auto refresh every 10 seconds
    setInterval(() => {
        window.location.reload();
    }, 10000);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\queue\display.blade.php ENDPATH**/ ?>