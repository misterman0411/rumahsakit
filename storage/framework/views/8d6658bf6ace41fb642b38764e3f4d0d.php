

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Resep</h1>
                <p class="text-gray-600 mt-2"><?php echo e($prescription->prescription_number); ?></p>
            </div>
            <div class="flex space-x-2">
                <?php if($prescription->status === 'pending'): ?>
                    <form action="<?php echo e(route('prescriptions.verify', $prescription)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Verifikasi
                        </button>
                    </form>
                <?php endif; ?>
                <?php if($prescription->status === 'verified'): ?>
                    <form action="<?php echo e(route('prescriptions.dispense', $prescription)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Serahkan Obat
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Prescription Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Resep</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nomor Resep</p>
                            <p class="font-semibold"><?php echo e($prescription->prescription_number); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                <?php if($prescription->status === 'dispensed'): ?> bg-green-100 text-green-800
                                <?php elseif($prescription->status === 'verified'): ?> bg-blue-100 text-blue-800
                                <?php elseif($prescription->status === 'cancelled'): ?> bg-red-100 text-red-800
                                <?php else: ?> bg-yellow-100 text-yellow-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($prescription->status)); ?>

                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Dibuat</p>
                            <p class="font-semibold"><?php echo e($prescription->created_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <?php if($prescription->verified_at): ?>
                        <div>
                            <p class="text-sm text-gray-500">Diverifikasi</p>
                            <p class="font-semibold"><?php echo e($prescription->verified_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <?php endif; ?>
                        <?php if($prescription->dispensed_at): ?>
                        <div>
                            <p class="text-sm text-gray-500">Diserahkan</p>
                            <p class="font-semibold"><?php echo e($prescription->dispensed_at->format('d/m/Y H:i')); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if($prescription->notes): ?>
                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Catatan</p>
                        <p class="text-gray-800 mt-1"><?php echo e($prescription->notes); ?></p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Medications -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Obat</h2>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $prescription->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg"><?php echo e($item->medication->name); ?></h3>
                                    <p class="text-sm text-gray-600"><?php echo e($item->medication->generic_name); ?></p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Harga</p>
                                    <p class="font-bold text-indigo-600">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-3">
                                <div>
                                    <p class="text-xs text-gray-500">Jumlah</p>
                                    <p class="font-semibold"><?php echo e($item->quantity); ?> <?php echo e($item->medication->unit); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Dosis</p>
                                    <p class="font-semibold"><?php echo e($item->dosage); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Frekuensi</p>
                                    <p class="font-semibold"><?php echo e($item->frequency); ?></p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Durasi</p>
                                    <p class="font-semibold"><?php echo e($item->duration); ?></p>
                                </div>
                            </div>
                            <?php if($item->instructions): ?>
                            <div class="mt-3 bg-blue-50 p-3 rounded-lg">
                                <p class="text-sm text-blue-800"><span class="font-semibold">Instruksi:</span> <?php echo e($item->instructions); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <!-- Total -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <p class="text-lg font-bold text-gray-800">Total</p>
                            <p class="text-2xl font-bold text-indigo-600">
                                Rp <?php echo e(number_format($prescription->items->sum('price'), 0, ',', '.')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Patient Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Pasien</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">No. RM</p>
                            <p class="font-semibold"><?php echo e($prescription->patient->medical_record_number); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold"><?php echo e($prescription->patient->name); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jenis Kelamin</p>
                            <p><?php echo e($prescription->patient->gender === 'male' ? 'Laki-laki' : 'Perempuan'); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Lahir</p>
                            <p><?php echo e(\Carbon\Carbon::parse($prescription->patient->date_of_birth)->format('d/m/Y')); ?></p>
                        </div>
                        <?php if($prescription->patient->allergies): ?>
                        <div class="mt-3 bg-red-50 p-3 rounded-lg">
                            <p class="text-xs text-red-600 font-semibold mb-1">ALERGI:</p>
                            <p class="text-sm text-red-800"><?php echo e($prescription->patient->allergies); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Doctor Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Dokter Penanggung Jawab</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold"><?php echo e($prescription->doctor->user->name); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Spesialisasi</p>
                            <p><?php echo e($prescription->doctor->specialization); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">No. Lisensi</p>
                            <p><?php echo e($prescription->doctor->license_number); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Invoice -->
                <?php if($prescription->invoice): ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Tagihan</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">No. Invoice</p>
                            <p class="font-semibold"><?php echo e($prescription->invoice->invoice_number); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total</p>
                            <p class="text-2xl font-bold text-indigo-600">Rp <?php echo e(number_format($prescription->invoice->total_amount, 0, ',', '.')); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                <?php if($prescription->invoice->status === 'paid'): ?> bg-green-100 text-green-800
                                <?php else: ?> bg-yellow-100 text-yellow-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($prescription->invoice->status)); ?>

                            </span>
                        </div>
                        <a href="<?php echo e(route('billing.show', $prescription->invoice)); ?>"
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\rs\hospital-management-system\resources\views/prescriptions/show.blade.php ENDPATH**/ ?>