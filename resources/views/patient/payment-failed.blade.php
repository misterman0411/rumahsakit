@extends('layouts.patient')

@section('title', 'Pembayaran Gagal')
@section('subtitle', 'Transaksi tidak dapat diproses')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Failed Icon -->
        <div class="bg-gradient-to-br from-red-500 to-pink-600 p-8 text-center">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">Pembayaran Gagal</h2>
            <p class="text-red-100">Transaksi Anda tidak dapat diproses</p>
        </div>

        <!-- Details -->
        <div class="p-8">
            <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-red-600 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-red-900 mb-1">Transaksi Dibatalkan</h3>
                        <p class="text-red-700 text-sm mb-3">
                            Pembayaran Anda tidak dapat diproses. Hal ini bisa terjadi karena:
                        </p>
                        <ul class="text-red-700 text-sm space-y-1 list-disc list-inside">
                            <li>Pembayaran dibatalkan oleh pengguna</li>
                            <li>Saldo tidak mencukupi</li>
                            <li>Masalah teknis dengan payment gateway</li>
                            <li>Waktu pembayaran telah habis</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <a href="{{ route('patient.invoices') }}" class="block w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl text-center transition-all duration-200 shadow-lg hover:shadow-xl">
                    Coba Bayar Lagi
                </a>
                <a href="{{ route('patient.dashboard') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl text-center transition-all">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
