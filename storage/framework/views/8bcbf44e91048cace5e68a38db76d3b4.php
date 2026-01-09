<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Order Radiologi</h1>
                <p class="text-gray-600 mt-2"><?php echo e($radiology->nomor_permintaan); ?></p>
            </div>
            <div class="flex space-x-2">
                <?php if(in_array($radiology->status, ['menunggu', 'sedang_diproses'])): ?>
                    <button onclick="document.getElementById('interpretationModal').classList.remove('hidden')"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Input Hasil & Interpretasi
                    </button>
                <?php endif; ?>
                <a href="<?php echo e(route('radiology.index')); ?>"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Order</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nomor Order</p>
                            <p class="font-semibold"><?php echo e($radiology->nomor_permintaan); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                <?php if($radiology->status === 'selesai'): ?> bg-green-100 text-green-800
                                <?php elseif($radiology->status === 'sedang_diproses'): ?> bg-blue-100 text-blue-800
                                <?php elseif($radiology->status === 'menunggu'): ?> bg-yellow-100 text-yellow-800
                                <?php elseif($radiology->status === 'dibatalkan'): ?> bg-red-100 text-red-800
                                <?php else: ?> bg-gray-100 text-gray-800
                                <?php endif; ?>">
                                <?php
                                    $statusLabels = [
                                        'menunggu' => 'Menunggu',
                                        'sedang_diproses' => 'Sedang Diproses',
                                        'selesai' => 'Selesai',
                                        'dibatalkan' => 'Dibatalkan'
                                    ];
                                ?>
                                <?php echo e($statusLabels[$radiology->status] ?? $radiology->status); ?>

                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jenis Pemeriksaan</p>
                            <p class="font-semibold"><?php echo e($radiology->jenisTes->nama); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Order</p>
                            <p class="font-semibold"><?php echo e($radiology->created_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <?php if($radiology->waktu_pemeriksaan): ?>
                        <div>
                            <p class="text-sm text-gray-500">Waktu Pemeriksaan</p>
                            <p class="font-semibold"><?php echo e($radiology->waktu_pemeriksaan->format('d/m/Y H:i')); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if($radiology->catatan_klinis): ?>
                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Catatan Klinis</p>
                        <p class="text-gray-800 mt-1"><?php echo e($radiology->catatan_klinis); ?></p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Results -->
                <?php if($radiology->hasil): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Hasil Pemeriksaan</h2>
                    <div class="mb-4">
                        <p class="text-gray-800"><?php echo e($radiology->hasil); ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Interpretation -->
                <?php if($radiology->interpretasi): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Interpretasi</h2>
                    <div>
                        <p class="text-gray-800"><?php echo e($radiology->interpretasi); ?></p>
                    </div>
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
                            <p class="font-semibold"><?php echo e($radiology->pasien->no_rekam_medis); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold"><?php echo e($radiology->pasien->nama); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jenis Kelamin</p>
                            <p><?php echo e($radiology->pasien->jenis_kelamin === 'laki_laki' ? 'Laki-laki' : 'Perempuan'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Lahir</p>
                            <p><?php echo e(\Carbon\Carbon::parse($radiology->pasien->tanggal_lahir)->format('d/m/Y')); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Doctor Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Dokter Pengirim</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold"><?php echo e($radiology->dokter->user->nama); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Spesialisasi</p>
                            <p><?php echo e($radiology->dokter->spesialisasi); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Invoice -->
                <?php if($radiology->tagihan): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Tagihan</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">No. Invoice</p>
                            <p class="font-semibold"><?php echo e($radiology->tagihan->nomor_tagihan); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total</p>
                            <p class="text-2xl font-bold text-indigo-600">Rp <?php echo e(number_format($radiology->tagihan->total, 0, ',', '.')); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                <?php if($radiology->tagihan->status === 'lunas'): ?> bg-green-100 text-green-800
                                <?php else: ?> bg-yellow-100 text-yellow-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($radiology->tagihan->status)); ?>

                            </span>
                        </div>
                        <a href="<?php echo e(route('billing.show', $radiology->tagihan)); ?>"
                            class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            Lihat Detail Tagihan
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Interpretation Modal -->
<div id="interpretationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Input Hasil & Interpretasi</h2>
        </div>
        <form action="<?php echo e(route('radiology.enter-interpretation', $radiology)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hasil Pemeriksaan</label>
                    <textarea name="hasil" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        placeholder="Deskripsi hasil pemeriksaan radiologi..."><?php echo e(old('hasil', $radiology->hasil)); ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Interpretasi</label>
                    <textarea name="interpretasi" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        placeholder="Interpretasi medis dari hasil pemeriksaan..."><?php echo e(old('interpretasi', $radiology->interpretasi)); ?></textarea>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('interpretationModal').classList.add('hidden')"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\radiology\show_old.blade.php ENDPATH**/ ?>