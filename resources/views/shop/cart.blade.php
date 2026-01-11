<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - MedCare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <x-navbar />

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-16">
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900">Keranjang Belanja</h1>
            <p class="text-gray-500 mt-2">Periksa kembali item obat yang akan Anda beli.</p>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center shadow-sm relative" role="alert">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="block sm:inline font-medium">{{ session('success') }}</span>
                 <button onclick="this.parentElement.style.display='none'" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-green-400 hover:text-green-600">
                    <svg class="fill-current h-6 w-6" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                </button>
            </div>
        @endif

        @if(!$cart || $cart->items->count() == 0)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Keranjang Anda Kosong</h3>
                <p class="text-gray-500 mb-8">Anda belum menambahkan obat apapun ke keranjang.</p>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg shadow-lg hover:shadow-xl transition-all">
                    Mulai Belanja
                </a>
            </div>
        @else
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items List -->
                <div class="flex-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <h3 class="font-semibold text-gray-700">Daftar Item ({{ $cart->items->count() }})</h3>
                        </div>
                        <div class="divide-y divide-gray-100">
                            @foreach($cart->items as $item)
                            <div class="p-6 flex flex-col sm:flex-row gap-6 items-center">
                                <!-- Image (Placeholder) -->
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                     <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                    </svg>
                                </div>
                                
                                <!-- Details -->
                                <div class="flex-1 text-center sm:text-left">
                                    <h4 class="text-lg font-bold text-gray-900">{{ $item->medication->nama }}</h4>
                                    <p class="text-sm text-gray-500 mb-2">{{ $item->medication->kategori }}</p>
                                    <div class="text-indigo-600 font-bold">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </div>
                                </div>

                                <!-- Quantity -->
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PATCH')
                                    <label class="text-xs text-gray-500 uppercase font-semibold">Qty:</label>
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="w-16 px-2 py-1 border border-gray-300 rounded-lg text-center focus:outline-none focus:ring-2 focus:ring-indigo-500" onchange="this.form.submit()">
                                </form>

                                <!-- Actions -->
                                <div class="flex flex-col items-end gap-2">
                                     <div class="font-bold text-gray-900 text-lg">
                                        Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                     </div>
                                     <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium flex items-center bg-red-50 hover:bg-red-100 px-3 py-1 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                     </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="{{ route('shop.index') }}" class="text-indigo-600 font-medium hover:text-indigo-800 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path></svg>
                            Lanjutkan Belanja
                        </a>
                    </div>
                </div>

                <!-- Summary Sidebar -->
                <div class="w-full lg:w-96">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-28">
                        <h3 class="text-lg font-bold text-gray-900 mb-6">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between text-gray-600">
                                <span>Total Harga (Item)</span>
                                <span>Rp {{ number_format($cart->items->sum(function($item){ return $item->price * $item->quantity; }), 0, ',', '.') }}</span>
                            </div>
                            <!-- Shipping cost could be calculated later -->
                            
                            <div class="border-t border-gray-100 pt-4 flex justify-between items-center">
                                <span class="text-lg font-bold text-gray-900">Total</span>
                                <span class="text-xl font-bold text-indigo-600">Rp {{ number_format($cart->items->sum(function($item){ return $item->price * $item->quantity; }), 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="block w-full text-center mt-8 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl hover:scale-[1.02] transition-all duration-300">
                            Checkout Sekarang
                        </a>
                        
                        <div class="mt-6 flex items-center justify-center gap-2 text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <span class="text-xs font-medium">Pembayaran Aman & Terenkripsi</span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

</body>
</html>
