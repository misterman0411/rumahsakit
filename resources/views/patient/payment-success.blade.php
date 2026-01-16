@extends('layouts.patient')

@section('title', 'Pembayaran Berhasil')
@section('subtitle', 'Transaksi Anda telah diproses')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Success Icon -->
        <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-8 text-center">
            <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">Pembayaran Berhasil!</h2>
            <p class="text-green-100">Transaksi Anda telah berhasil diproses</p>
        </div>

        <!-- Details -->
        <div class="p-8">
            <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-6">
                <div class="flex items-start">
                    <svg class="w-6 h-6 text-green-600 mr-3 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-green-900 mb-1">Pembayaran Dikonfirmasi</h3>
                        <p class="text-green-700 text-sm">
                            Tagihan Anda telah lunas. Anda akan menerima email konfirmasi pembayaran segera.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <a href="{{ route('patient.invoices') }}" class="block w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl text-center transition-all duration-200 shadow-lg hover:shadow-xl">
                    Lihat Riwayat Tagihan
                </a>
                <a href="{{ route('patient.dashboard') }}" class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl text-center transition-all">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
