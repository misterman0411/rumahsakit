<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - MedCare</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    </div>
                    <span class="font-bold text-2xl text-gray-900">MedCare</span>
                </a>
                <a href="<?php echo e(route('shop.index')); ?>" class="text-indigo-600 font-medium hover:text-indigo-700">Continue Shopping</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

        <?php if(session('success')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>
        
        <?php if(session('error')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo e(session('error')); ?></span>
            </div>
        <?php endif; ?>

        <?php if(session('cart') && count(session('cart')) > 0): ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Product</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Quantity</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Total</th>
                                <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php $total = 0 ?>
                            <?php $__currentLoopData = session('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $total += $details['price'] * $details['quantity'] ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div class="font-medium text-gray-900"><?php echo e($details['name']); ?></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <form action="<?php echo e(route('cart.update')); ?>" method="POST" class="flex items-center max-w-[100px]">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PATCH'); ?>
                                        <input type="hidden" name="id" value="<?php echo e($id); ?>">
                                        <input type="number" name="quantity" value="<?php echo e($details['quantity']); ?>" min="1" class="w-16 border border-gray-300 rounded-md px-2 py-1 text-sm focus:ring-indigo-500 focus:border-indigo-500" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    Rp <?php echo e(number_format($details['price'] * $details['quantity'], 0, ',', '.')); ?>

                                </td>
                                <td class="px-6 py-4">
                                    <form action="<?php echo e(route('cart.destroy')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <input type="hidden" name="id" value="<?php echo e($id); ?>">
                                        <button class="text-red-500 hover:text-red-700 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h2>
                        <div class="flex justify-between items-center mb-4 text-gray-600">
                            <span>Subtotal</span>
                            <span>Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                        </div>
                        <div class="flex justify-between items-center mb-6 text-gray-600">
                            <span>Tax (0%)</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="border-t border-gray-100 pt-4 flex justify-between items-center mb-8">
                            <span class="font-bold text-lg text-gray-900">Total</span>
                            <span class="font-bold text-xl text-indigo-600">Rp <?php echo e(number_format($total, 0, ',', '.')); ?></span>
                        </div>
                        
                        <form action="<?php echo e(route('cart.checkout')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                                Proceed to Checkout
                            </button>
                        </form>
                        
                        <div class="mt-6 flex items-center justify-center gap-2 text-gray-400">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                             <span class="text-xs">Secure Checkout via Midtrans</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-24 bg-white rounded-3xl border border-dashed border-gray-300">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
                <h3 class="text-xl font-medium text-gray-900">Your cart is empty</h3>
                <p class="text-gray-500 mt-2 mb-8">Looks like you haven't added any items to your cart yet.</p>
                <a href="<?php echo e(route('shop.index')); ?>" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                    Start Shopping
                </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php /**PATH E:\laragon\www\rumahsakit\resources\views/shop/cart.blade.php ENDPATH**/ ?>