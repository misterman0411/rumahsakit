@extends('layouts.patient')

@section('title', 'Resep Obat')
@section('subtitle', 'Riwayat resep obat Anda')

@section('content')
@if(!$patient)
    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
        <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <h3 class="text-lg font-semibold text-yellow-800 mb-2">Data Pasien Belum Terdaftar</h3>
        <p class="text-yellow-700">Silakan hubungi bagian pendaftaran untuk mendaftarkan data pasien Anda.</p>
    </div>
@elseif($prescriptions->count() > 0)
    <div class="space-y-4">
        @foreach($prescriptions as $prescription)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center text-white mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $prescription->dokter->user->nama ?? 'Dokter' }}</h4>
                            <p class="text-sm text-gray-500">{{ $prescription->created_at->format('d F Y') }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        @if($prescription->status === 'dispensed') bg-green-100 text-green-700
                        @elseif($prescription->status === 'verified') bg-blue-100 text-blue-700
                        @elseif($prescription->status === 'pending') bg-yellow-100 text-yellow-700
                        @else bg-gray-100 text-gray-700
                        @endif">
                        {{ ucfirst($prescription->status) }}
                    </span>
                </div>
                
                <div class="p-6">
                    @if($prescription->items && $prescription->items->count() > 0)
                        <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Daftar Obat</h5>
                        <div class="space-y-2">
                            @foreach($prescription->items as $item)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $item->obat->nama ?? 'Obat' }}</p>
                                        <p class="text-sm text-gray-500">{{ $item->dosis ?? '-' }} • {{ $item->jumlah ?? 0 }} {{ $item->satuan ?? 'pcs' }}</p>
                                    </div>
                                    @if($item->instruksi)
                                        <p class="text-sm text-gray-600">{{ $item->instruksi }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">Tidak ada detail obat</p>
                    @endif
                    
                    @if($prescription->catatan)
                        <div class="mt-4 bg-blue-50 rounded-xl p-4">
                            <h5 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">Catatan</h5>
                            <p class="text-sm text-blue-800">{{ $prescription->catatan }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    @if($prescriptions->hasPages())
        <div class="mt-6">
            {{ $prescriptions->links() }}
        </div>
    @endif
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Resep</h3>
        <p class="text-gray-500">Anda belum memiliki riwayat resep obat.</p>
    </div>
@endif
@endsection
