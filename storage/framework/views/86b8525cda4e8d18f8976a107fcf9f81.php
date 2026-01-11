<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - MedCare</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <?php if (isset($component)) { $__componentOriginala591787d01fe92c5706972626cdf7231 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala591787d01fe92c5706972626cdf7231 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navbar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $attributes = $__attributesOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__attributesOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala591787d01fe92c5706972626cdf7231)): ?>
<?php $component = $__componentOriginala591787d01fe92c5706972626cdf7231; ?>
<?php unset($__componentOriginala591787d01fe92c5706972626cdf7231); ?>
<?php endif; ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16">
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-bold text-gray-900">Checkout Pesanan</h1>
            <p class="text-gray-500 mt-2">Lengkapi informasi pengiriman untuk menyelesaikan pesanan.</p>
        </div>

        <form action="<?php echo e(route('checkout.store')); ?>" method="POST" class="flex flex-col lg:flex-row gap-8">
            <?php echo csrf_field(); ?>
            
            <!-- Shipping Information -->
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-semibold text-gray-700 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Informasi Pengiriman
                        </h3>
                    </div>
                    
                    <div class="p-8 space-y-6">
                        <!-- Name & Phone -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Penerima</label>
                                <input type="text" value="<?php echo e(Auth::user()->nama); ?>" readonly class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">No. Telepon <span class="text-red-500">*</span></label>
                                <input type="tel" name="shipping_phone" value="<?php echo e(old('shipping_phone', Auth::user()->patient->no_hp ?? '')); ?>" required placeholder="Contoh: 08123456789" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            </div>
                        </div>

                        <!-- Delivery Method -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pengiriman <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-500 transition-colors">
                                    <input type="radio" name="delivery_method" value="delivery" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" checked onchange="toggleAddress(true)">
                                    <span class="ml-3 flex flex-col">
                                        <span class="block text-sm font-medium text-gray-900">Delivery Home</span>
                                        <span class="block text-xs text-gray-500">Diantar ke rumah</span>
                                    </span>
                                </label>
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-500 transition-colors">
                                    <input type="radio" name="delivery_method" value="pickup" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" onchange="toggleAddress(false)">
                                    <span class="ml-3 flex flex-col">
                                        <span class="block text-sm font-medium text-gray-900">Pick Up</span>
                                        <span class="block text-xs text-gray-500">Ambil di Apotek</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Address -->
                        <div id="addressField">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                            <textarea name="shipping_address" id="shippingAddressInput" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, Kecamatan, Kota, Kode Pos" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"><?php echo e(old('shipping_address', Auth::user()->patient->alamat ?? '')); ?></textarea>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pembayaran <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-500 transition-colors">
                                    <input type="radio" name="payment_method" value="qris" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" checked>
                                    <span class="ml-3 font-medium text-gray-900">QRIS</span>
                                </label>
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-500 transition-colors">
                                    <input type="radio" name="payment_method" value="debit" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                    <span class="ml-3 font-medium text-gray-900">Debit Card</span>
                                </label>
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-500 transition-colors">
                                    <input type="radio" name="payment_method" value="credit" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                    <span class="ml-3 font-medium text-gray-900">Credit Card</span>
                                </label>
                                <label class="relative flex items-center p-4 border border-gray-200 rounded-xl cursor-pointer hover:border-indigo-500 transition-colors">
                                    <input type="radio" name="payment_method" value="cash" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                    <span class="ml-3 font-medium text-gray-900">Cash</span>
                                </label>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Pengiriman (Opsional)</label>
                            <textarea name="notes" rows="2" placeholder="Contoh: Titipkan di pos satpam jika tidak ada orang" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="w-full lg:w-96">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                    <h3 class="text-lg font-bold text-gray-900 mb-6">Ringkasan Pesanan</h3>
                    
                    <div class="space-y-4 mb-6">
                        <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex justify-between items-start text-sm">
                            <span class="text-gray-600 flex-1 pr-2"><?php echo e($item->medication->nama); ?> <span class="text-xs text-gray-400">x<?php echo e($item->quantity); ?></span></span>
                            <span class="font-medium text-gray-900">Rp <?php echo e(number_format($item->price * $item->quantity, 0, ',', '.')); ?></span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="border-t border-gray-100 pt-4 space-y-2">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <span>Rp <?php echo e(number_format($cart->items->sum(function($item){ return $item->price * $item->quantity; }), 0, ',', '.')); ?></span>
                        </div>
                        <div class="flex justify-between text-gray-600">
                            <span>Biaya Pengiriman</span>
                            <span class="text-green-600 font-medium">Gratis</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-gray-100 mt-2">
                            <span class="text-lg font-bold text-gray-900">Total Tagihan</span>
                            <span class="text-xl font-bold text-indigo-600">Rp <?php echo e(number_format($cart->items->sum(function($item){ return $item->price * $item->quantity; }), 0, ',', '.')); ?></span>
                        </div>
                    </div>

                    <button type="submit" class="w-full mt-8 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        Bayar Sekarang
                    </button>
                    
                    <p class="text-xs text-gray-400 text-center mt-4">
                        Dengan melanjutkan, Anda menyetujui Syarat & Ketentuan kami.
                    </p>
                </div>
            </div>
        </form>
    </div>

    <script>
        function toggleAddress(show) {
            const addressField = document.getElementById('addressField');
            const addressInput = document.getElementById('shippingAddressInput');
            if (show) {
                addressField.style.display = 'block';
                addressInput.setAttribute('required', 'required');
            } else {
                addressField.style.display = 'none';
                addressInput.removeAttribute('required');
            }
        }
    </script>
</body>
</html>
<?php /**PATH E:\laragon\www\rumahsakit\resources\views/shop/checkout.blade.php ENDPATH**/ ?>