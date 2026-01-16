@extends('layouts.patient')

@section('title', 'Pembayaran Tertunda')
@section('subtitle', 'Menunggu konfirmasi pembayaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Pending Icon -->
        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 p-8 text-center">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-16 h-16 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">Pembayaran Tertunda</h2>
            <p class="text-yellow-100">Menunggu konfirmasi pembayaran Anda</p>
        </div>

        <!-- Details -->
        <div class="p-8">
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-yellow-600 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-yellow-900 mb-1">Menunggu Konfirmasi</h3>
                        <p class="text-yellow-700 text-sm">
                            Pembayaran Anda sedang diproses. Silakan selesaikan pembayaran Anda atau tunggu hingga sistem mengkonfirmasi transaksi. 
                            Proses ini biasanya memakan waktu beberapa menit hingga 24 jam tergantung metode pembayaran.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <a href="{{ route('patient.invoices') }}" class="block w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl text-center transition-all duration-200 shadow-lg hover:shadow-xl">
                    Cek Status Tagihan
                </a>
                <a href="{{ route('patient.dashboard') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl text-center transition-all">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
