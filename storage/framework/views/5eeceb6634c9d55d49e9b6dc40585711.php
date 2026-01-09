<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Order Laboratorium</h1>
                <p class="text-gray-600 mt-2"><?php echo e($laboratory->nomor_permintaan); ?></p>
            </div>
            <div class="flex space-x-2">
                <?php if($laboratory->status === 'menunggu'): ?>
                    <form action="<?php echo e(route('laboratory.collect-sample', $laboratory)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Ambil Sampel
                        </button>
                    </form>
                <?php endif; ?>
                <?php if($laboratory->status === 'sampel_diambil'): ?>
                    <button onclick="document.getElementById('resultsModal').classList.remove('hidden')"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Input Hasil
                    </button>
                <?php endif; ?>
                <?php if($laboratory->status === 'sedang_diproses'): ?>
                    <form action="<?php echo e(route('laboratory.verify', $laboratory)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Verifikasi Hasil
                        </button>
                    </form>
                <?php endif; ?>
                <a href="<?php echo e(route('laboratory.index')); ?>"
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
                            <p class="font-semibold"><?php echo e($laboratory->nomor_permintaan); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                <?php if($laboratory->status === 'selesai'): ?> bg-green-100 text-green-800
                                <?php elseif($laboratory->status === 'sedang_diproses'): ?> bg-blue-100 text-blue-800
                                <?php elseif($laboratory->status === 'sampel_diambil'): ?> bg-yellow-100 text-yellow-800
                                <?php else: ?> bg-gray-100 text-gray-800
                                <?php endif; ?>">
                                <?php if($laboratory->status == 'menunggu'): ?> Menunggu
                                <?php elseif($laboratory->status == 'sampel_diambil'): ?> Sampel Diambil
                                <?php elseif($laboratory->status == 'sedang_diproses'): ?> Sedang Diproses
                                <?php elseif($laboratory->status == 'selesai'): ?> Selesai
                                <?php else: ?> <?php echo e(ucfirst($laboratory->status)); ?>

                                <?php endif; ?>
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jenis Pemeriksaan</p>
                            <p class="font-semibold"><?php echo e($laboratory->jenisTes->nama); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Order</p>
                            <p class="font-semibold"><?php echo e($laboratory->created_at->format('d/m/Y H:i')); ?></p>
                        </div>
                    </div>
                    <?php if($laboratory->informasi_klinis): ?>
                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Informasi Klinis</p>
                        <p class="text-gray-800 mt-1"><?php echo e($laboratory->informasi_klinis); ?></p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Results -->
                <?php if($laboratory->hasilLaboratorium): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Hasil Pemeriksaan</h2>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Hasil</p>
                            <p class="font-semibold text-gray-800"><?php echo e($laboratory->hasilLaboratorium->hasil); ?></p>
                        </div>
                        <?php if($laboratory->hasilLaboratorium->nilai): ?>
                        <div>
                            <p class="text-sm text-gray-500">Nilai</p>
                            <p class="font-semibold text-gray-800">
                                <?php echo e($laboratory->hasilLaboratorium->nilai); ?>

                                <?php if($laboratory->hasilLaboratorium->satuan): ?>
                                    <?php echo e($laboratory->hasilLaboratorium->satuan); ?>

                                <?php endif; ?>
                            </p>
                        </div>
                        <?php endif; ?>
                        <?php if($laboratory->hasilLaboratorium->nilai_rujukan): ?>
                        <div>
                            <p class="text-sm text-gray-500">Nilai Rujukan</p>
                            <p class="text-gray-800"><?php echo e($laboratory->hasilLaboratorium->nilai_rujukan); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if($laboratory->hasilLaboratorium->status): ?>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-2 py-1 rounded text-sm font-semibold
                                <?php if($laboratory->hasilLaboratorium->status === 'normal'): ?> bg-green-100 text-green-800
                                <?php elseif($laboratory->hasilLaboratorium->status === 'kritis'): ?> bg-red-100 text-red-800
                                <?php elseif($laboratory->hasilLaboratorium->status === 'tinggi'): ?> bg-orange-100 text-orange-800
                                <?php elseif($laboratory->hasilLaboratorium->status === 'rendah'): ?> bg-yellow-100 text-yellow-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($laboratory->hasilLaboratorium->status)); ?>

                            </span>
                        </div>
                        <?php endif; ?>
                        <?php if($laboratory->hasilLaboratorium->catatan): ?>
                        <div>
                            <p class="text-sm text-gray-500">Catatan</p>
                            <p class="text-gray-800"><?php echo e($laboratory->hasilLaboratorium->catatan); ?></p>
                        </div>
                        <?php endif; ?>
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
                            <p class="font-semibold"><?php echo e($laboratory->pasien->no_rekam_medis); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold"><?php echo e($laboratory->pasien->nama); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jenis Kelamin</p>
                            <p><?php echo e($laboratory->pasien->gender === 'male' ? 'Laki-laki' : 'Perempuan'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Lahir</p>
                            <p><?php echo e(\Carbon\Carbon::parse($laboratory->pasien->tanggal_lahir)->format('d/m/Y')); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Doctor Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Dokter Pengirim</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold"><?php echo e($laboratory->dokter->user->nama); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Spesialisasi</p>
                            <p><?php echo e($laboratory->dokter->spesialisasi); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Invoice -->
                <?php if($laboratory->tagihan): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Tagihan</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">No. Invoice</p>
                            <p class="font-semibold"><?php echo e($laboratory->tagihan->nomor_tagihan); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total</p>
                            <p class="text-2xl font-bold text-indigo-600">Rp <?php echo e(number_format($laboratory->tagihan->total, 0, ',', '.')); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                <?php if($laboratory->tagihan->status === 'lunas'): ?> bg-green-100 text-green-800
                                <?php else: ?> bg-yellow-100 text-yellow-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($laboratory->tagihan->status)); ?>

                            </span>
                        </div>
                        <a href="<?php echo e(route('billing.show', $laboratory->tagihan)); ?>"
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

<!-- Results Modal -->
<div id="resultsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Input Hasil Laboratorium</h2>
        </div>
        <form action="<?php echo e(route('laboratory.enter-results', $laboratory)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="p-6">
                <div id="resultsContainer" class="space-y-4">
                    <div class="result-item border border-gray-200 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Test</label>
                                <input type="text" name="results[0][test_name]" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Hasil</label>
                                <input type="text" name="results[0][result_value]" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Satuan</label>
                                <input type="text" name="results[0][unit]"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nilai Normal</label>
                                <input type="text" name="results[0][normal_range]"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select name="results[0][is_abnormal]"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    <option value="0">Normal</option>
                                    <option value="1">Abnormal</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan</label>
                                <textarea name="results[0][notes]" rows="2"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addResult()" class="mt-4 text-indigo-600 hover:text-indigo-700 font-semibold">
                    + Tambah Hasil Test
                </button>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('resultsModal').classList.add('hidden')"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700">
                    Simpan Hasil
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let resultIndex = 1;
function addResult() {
    const container = document.getElementById('resultsContainer');
    const newResult = `
        <div class="result-item border border-gray-200 rounded-lg p-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Test</label>
                    <input type="text" name="results[${resultIndex}][test_name]" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hasil</label>
                    <input type="text" name="results[${resultIndex}][result_value]" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Satuan</label>
                    <input type="text" name="results[${resultIndex}][unit]"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nilai Normal</label>
                    <input type="text" name="results[${resultIndex}][normal_range]"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="results[${resultIndex}][is_abnormal]"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="0">Normal</option>
                        <option value="1">Abnormal</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan</label>
                    <textarea name="results[${resultIndex}][notes]" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newResult);
    resultIndex++;
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rumahsakit\resources\views/laboratory/show.blade.php ENDPATH**/ ?>