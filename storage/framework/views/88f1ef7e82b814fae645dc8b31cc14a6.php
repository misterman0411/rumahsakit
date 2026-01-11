

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Order Radiologi</h1>
                <p class="text-gray-600 mt-2"><?php echo e($radiology->nomor_permintaan); ?>

                    <?php if($radiology->version > 1): ?>
                        <span class="text-sm text-purple-600 font-semibold">(Versi <?php echo e($radiology->version); ?>)</span>
                    <?php endif; ?>
                </p>
            </div>
            <div class="flex space-x-2">
                <?php if($radiology->report_status === 'final' && $radiology->image_path): ?>
                    <a href="<?php echo e(asset('storage/' . $radiology->image_path)); ?>" target="_blank"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Lihat Gambar
                    </a>
                <?php endif; ?>
                
                <?php if($radiology->report_status === 'draft' && $radiology->hasil && ((auth()->user()->peran->nama ?? null) === 'radiologist' || (auth()->user()->peran->nama ?? null) === 'admin')): ?>
                    <button onclick="document.getElementById('interpretationModal').classList.remove('hidden')"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Edit Hasil
                    </button>
                    <form action="<?php echo e(route('radiology.finalize', $radiology)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" onclick="return confirm('Finalisasi laporan? Laporan tidak bisa diedit setelah difinalisasi.')"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold">
                            ✓ Finalisasi & Tandatangani
                        </button>
                    </form>
                <?php endif; ?>

                <?php if($radiology->report_status === 'draft' && $radiology->hasil && ((auth()->user()->peran->nama ?? null) === 'doctor')): ?>
                    <div class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg text-sm">
                        ⏳ Menunggu radiologist finalisasi laporan
                    </div>
                <?php endif; ?>

                <?php if($radiology->report_status === 'final' && ((auth()->user()->peran->nama ?? null) === 'radiologist' || (auth()->user()->peran->nama ?? null) === 'admin')): ?>
                    <button onclick="document.getElementById('revisionModal').classList.remove('hidden')"
                        class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                        Buat Revisi
                    </button>
                <?php endif; ?>

                <?php if(in_array($radiology->status, ['menunggu', 'sedang_diproses']) && !$radiology->hasil && ((auth()->user()->peran->nama ?? null) === 'radiologist' || (auth()->user()->peran->nama ?? null) === 'admin')): ?>
                    <button onclick="document.getElementById('interpretationModal').classList.remove('hidden')"
                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Input Hasil & Interpretasi
                    </button>
                <?php endif; ?>

                <?php if($radiology->hasil && $radiology->interpretasi): ?>
                    <a href="<?php echo e(route('radiology.print', $radiology)); ?>" target="_blank"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak / Export
                    </a>
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
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-xl font-bold text-gray-800">Informasi Order</h2>
                        <?php if($radiology->report_status): ?>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                <?php echo e($radiology->report_status === 'final' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                <?php echo e($radiology->report_status === 'final' ? '✓ FINAL' : '📝 DRAFT'); ?>

                            </span>
                        <?php endif; ?>
                    </div>
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
                        <p class="text-gray-800 mt-1 whitespace-pre-line"><?php echo e($radiology->catatan_klinis); ?></p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Image Viewer -->
                <?php if($radiology->image_path): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Gambar Radiologi</h2>
                    <div class="bg-gray-100 p-4 rounded-lg">
                        <img src="<?php echo e(asset('storage/' . $radiology->image_path)); ?>" 
                             alt="Radiology Image" 
                             class="w-full h-auto rounded cursor-pointer hover:opacity-90"
                             onclick="document.getElementById('imageModal').classList.remove('hidden')">
                        <p class="text-sm text-gray-500 mt-2 text-center">Klik gambar untuk memperbesar</p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Results -->
                <?php if($radiology->hasil): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Hasil Pemeriksaan</h2>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-800 whitespace-pre-line"><?php echo e($radiology->hasil); ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Interpretation -->
                <?php if($radiology->interpretasi): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Interpretasi</h2>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-gray-800 whitespace-pre-line"><?php echo e($radiology->interpretasi); ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Digital Signature -->
                <?php if($radiology->signed_by && $radiology->signed_at): ?>
                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl border-2 border-green-200 p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 mb-2">Laporan Telah Ditandatangani</h3>
                            <div class="space-y-1">
                                <p class="text-sm text-gray-700"><span class="font-semibold">Radiolog:</span> <?php echo e($radiology->signedBy->nama); ?></p>
                                <p class="text-sm text-gray-700"><span class="font-semibold">Tanggal & Waktu:</span> <?php echo e($radiology->signed_at->format('d/m/Y H:i:s')); ?></p>
                                <p class="text-xs text-gray-500 mt-2">Dokumen ini sah secara hukum dan dilindungi dari perubahan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Revision History -->
                <?php if($radiology->parentRevision || $radiology->revisions->count() > 0): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Riwayat Revisi</h2>
                    <div class="space-y-3">
                        <?php if($radiology->parentRevision): ?>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <span class="text-2xl">📄</span>
                            <div>
                                <p class="font-semibold text-gray-800">Versi Sebelumnya (v<?php echo e($radiology->parentRevision->version); ?>)</p>
                                <a href="<?php echo e(route('radiology.show', $radiology->parentRevision)); ?>" 
                                   class="text-sm text-blue-600 hover:underline">Lihat versi sebelumnya →</a>
                            </div>
                        </div>
                        <?php endif; ?>
                        
                        <?php $__currentLoopData = $radiology->revisions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $revision): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg">
                            <span class="text-2xl">🔄</span>
                            <div>
                                <p class="font-semibold text-gray-800">Revisi Terbaru (v<?php echo e($revision->version); ?>)</p>
                                <p class="text-sm text-gray-600">Dibuat <?php echo e($revision->created_at->format('d/m/Y H:i')); ?></p>
                                <a href="<?php echo e(route('radiology.show', $revision)); ?>" 
                                   class="text-sm text-blue-600 hover:underline">Lihat revisi →</a>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                            <p><?php echo e($radiology->pasien->gender === 'male' ? 'Laki-laki' : 'Perempuan'); ?></p>
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

                <!-- Audit Trail -->
                <?php if($radiology->hasil_diinput_oleh || $radiology->signed_by): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Riwayat Pemeriksaan</h2>
                    <div class="space-y-4">
                        <!-- Order Created -->
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Order Dibuat</p>
                                <p class="text-sm text-gray-600">Oleh: <?php echo e($radiology->dokter->user->nama); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($radiology->created_at->format('d/m/Y H:i')); ?></p>
                            </div>
                        </div>

                        <!-- Hasil Diinput -->
                        <?php if($radiology->hasil_diinput_oleh): ?>
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Hasil Diinput</p>
                                <p class="text-sm text-gray-600">Oleh: <?php echo e($radiology->hasilDiinputOleh->nama); ?></p>
                                <?php if($radiology->hasilDiinputOleh->peran): ?>
                                <p class="text-xs text-gray-500">Role: <?php echo e(ucfirst(str_replace('_', ' ', $radiology->hasilDiinputOleh->peran->nama))); ?></p>
                                <?php endif; ?>
                                <?php if($radiology->waktu_input_hasil): ?>
                                <p class="text-xs text-gray-500"><?php echo e($radiology->waktu_input_hasil->format('d/m/Y H:i')); ?></p>
                                <?php endif; ?>
                                <?php if($radiology->report_status === 'draft'): ?>
                                <span class="inline-block mt-1 px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded">DRAFT</span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Ditandatangani -->
                        <?php if($radiology->signed_by): ?>
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Laporan Ditandatangani</p>
                                <p class="text-sm text-gray-600">Oleh: <?php echo e($radiology->signedBy->nama); ?></p>
                                <?php if($radiology->signedBy->peran): ?>
                                <p class="text-xs text-gray-500">Role: <?php echo e(ucfirst(str_replace('_', ' ', $radiology->signedBy->peran->nama))); ?></p>
                                <?php endif; ?>
                                <?php if($radiology->signed_at): ?>
                                <p class="text-xs text-gray-500"><?php echo e($radiology->signed_at->format('d/m/Y H:i:s')); ?></p>
                                <?php endif; ?>
                                <span class="inline-block mt-1 px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded">FINAL</span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Revisi Timeline -->
                        <?php if($radiology->parentRevision): ?>
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Revisi dari Versi <?php echo e($radiology->parentRevision->version); ?></p>
                                <a href="<?php echo e(route('radiology.show', $radiology->parentRevision)); ?>" 
                                   class="text-sm text-blue-600 hover:underline">Lihat versi sebelumnya →</a>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if(!$radiology->hasil_diinput_oleh && !$radiology->signed_by): ?>
                    <div class="mt-4 text-center text-sm text-gray-500 italic">
                        Belum ada aktivitas pemeriksaan
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

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
<div id="interpretationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Input Hasil & Interpretasi</h2>
        </div>
        <form action="<?php echo e(route('radiology.enter-interpretation', $radiology)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="p-6 space-y-4">
                <!-- Image Upload -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Upload Gambar (X-Ray, CT, MRI, Ultrasound)
                    </label>
                    <input type="file" name="image" accept="image/*,.dcm"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, DICOM (Max: 10MB)</p>
                </div>

                <!-- Hasil -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hasil Pemeriksaan *</label>
                    <textarea name="hasil" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                        placeholder="Deskripsi temuan radiologi..."><?php echo e(old('hasil', $radiology->hasil)); ?></textarea>
                </div>

                <!-- Interpretasi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Interpretasi *</label>
                    <textarea name="interpretasi" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                        placeholder="Kesimpulan dan rekomendasi..."><?php echo e(old('interpretasi', $radiology->interpretasi)); ?></textarea>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-blue-800">
                        💡 <strong>Info:</strong> Hasil akan disimpan sebagai <strong>DRAFT</strong> terlebih dahulu. 
                        Setelah yakin, Anda dapat memfinalisasi dan menandatangani laporan.
                    </p>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('interpretationModal').classList.add('hidden')"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white rounded-lg hover:from-purple-700 hover:to-blue-700">
                    Simpan sebagai Draft
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Revision Modal -->
<div id="revisionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Buat Revisi Laporan</h2>
        </div>
        <form action="<?php echo e(route('radiology.revise', $radiology)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="p-6 space-y-4">
                <div class="bg-orange-50 p-4 rounded-lg">
                    <p class="text-sm text-orange-800">
                        ⚠️ <strong>Perhatian:</strong> Revisi akan membuat versi baru dari laporan ini. 
                        Versi lama akan tetap tersimpan untuk audit trail.
                    </p>
                </div>

                <!-- Alasan Revisi -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Revisi *</label>
                    <textarea name="revision_reason" rows="3" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500"
                        placeholder="Jelaskan alasan revisi (minimal 10 karakter)..."></textarea>
                </div>

                <!-- Hasil Baru -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hasil Pemeriksaan (Revisi) *</label>
                    <textarea name="hasil" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500"
                        placeholder="Hasil yang sudah direvisi..."><?php echo e($radiology->hasil); ?></textarea>
                </div>

                <!-- Interpretasi Baru -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Interpretasi (Revisi) *</label>
                    <textarea name="interpretasi" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500"
                        placeholder="Interpretasi yang sudah direvisi..."><?php echo e($radiology->interpretasi); ?></textarea>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('revisionModal').classList.add('hidden')"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-lg hover:from-orange-700 hover:to-red-700">
                    Buat Revisi
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Image Zoom Modal -->
<?php if($radiology->image_path): ?>
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center p-4" onclick="this.classList.add('hidden')">
    <div class="max-w-6xl w-full">
        <img src="<?php echo e(asset('storage/' . $radiology->image_path)); ?>" alt="Radiology Image" class="w-full h-auto">
        <p class="text-white text-center mt-4">Klik di mana saja untuk menutup</p>
    </div>
</div>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views\radiology\show.blade.php ENDPATH**/ ?>