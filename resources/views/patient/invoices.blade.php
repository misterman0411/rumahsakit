@extends('layouts.patient')

@section('title', 'Tagihan')
@section('subtitle', 'Riwayat tagihan dan pembayaran Anda')

@section('content')
@if(!$patient)
    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
        <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <h3 class="text-lg font-semibold text-yellow-800 mb-2">Data Pasien Belum Terdaftar</h3>
        <p class="text-yellow-700">Silakan hubungi bagian pendaftaran untuk mendaftarkan data pasien Anda.</p>
    </div>
@elseif($invoices->count() > 0)
    <div class="space-y-4">
        @foreach($invoices as $invoice)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center text-white mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">Invoice #{{ $invoice->nomor_invoice ?? $invoice->id }}</h4>
                            <p class="text-sm text-gray-500">{{ $invoice->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xl font-bold text-gray-900">Rp {{ number_format($invoice->total ?? 0, 0, ',', '.') }}</p>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                            @if($invoice->status === 'paid') bg-green-100 text-green-700
                            @elseif($invoice->status === 'partial') bg-blue-100 text-blue-700
                            @elseif($invoice->status === 'unpaid') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700
                            @endif">
                            @if($invoice->status === 'paid') Lunas
                            @elseif($invoice->status === 'partial') Sebagian
                            @elseif($invoice->status === 'unpaid') Belum Bayar
                            @else {{ ucfirst($invoice->status) }}
                            @endif
                        </span>
                    </div>
                </div>
                
                <div class="p-6">
                    @if($invoice->items && $invoice->items->count() > 0)
                        <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Rincian</h5>
                        <div class="space-y-2 mb-4">
                            @foreach($invoice->items as $item)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <span class="text-gray-700">{{ $item->deskripsi ?? 'Item' }}</span>
                                    <span class="font-medium text-gray-900">Rp {{ number_format($item->jumlah ?? 0, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    @if($invoice->payments && $invoice->payments->count() > 0)
                        <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3 mt-4">Riwayat Pembayaran</h5>
                        <div class="space-y-2">
                            @foreach($invoice->payments as $payment)
                                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                    <div>
                                        <span class="text-green-700 font-medium">Pembayaran {{ $payment->created_at->format('d M Y') }}</span>
                                        <span class="text-sm text-green-600 ml-2">{{ $payment->metode_pembayaran ?? '' }}</span>
                                    </div>
                                    <span class="font-semibold text-green-700">Rp {{ number_format($payment->jumlah ?? 0, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    @if($invoices->hasPages())
        <div class="mt-6">
            {{ $invoices->links() }}
        </div>
    @endif
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Tagihan</h3>
        <p class="text-gray-500">Anda belum memiliki riwayat tagihan.</p>
    </div>
@endif
@endsection
