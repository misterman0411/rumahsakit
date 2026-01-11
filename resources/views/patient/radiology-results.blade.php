@extends('layouts.patient')

@section('title', 'Hasil Radiologi')
@section('subtitle', 'Riwayat pemeriksaan radiologi Anda')

@section('content')
@if(!$patient)
    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
        <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <h3 class="text-lg font-semibold text-yellow-800 mb-2">Data Pasien Belum Terdaftar</h3>
        <p class="text-yellow-700">Silakan hubungi bagian pendaftaran untuk mendaftarkan data pasien Anda.</p>
    </div>
@elseif($radiologyResults->count() > 0)
    <div class="space-y-4">
        @foreach($radiologyResults as $radiology)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center text-white mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $radiology->jenisTes->nama ?? 'Pemeriksaan Radiologi' }}</h4>
                            <p class="text-sm text-gray-500">{{ $radiology->created_at->format('d F Y') }} • Dr. {{ $radiology->dokter->user->nama ?? '-' }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        @if($radiology->status === 'completed') bg-green-100 text-green-700
                        @elseif($radiology->status === 'interpreted') bg-blue-100 text-blue-700
                        @elseif($radiology->status === 'scheduled') bg-yellow-100 text-yellow-700
                        @elseif($radiology->status === 'ordered') bg-orange-100 text-orange-700
                        @else bg-gray-100 text-gray-700
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $radiology->status)) }}
                    </span>
                </div>
                
                <div class="p-6">
                    @if($radiology->interpretasi)
                        <div class="bg-blue-50 rounded-xl p-4 mb-4">
                            <h5 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">Interpretasi</h5>
                            <p class="text-sm text-blue-800">{{ $radiology->interpretasi }}</p>
                        </div>
                    @endif
                    
                    @if($radiology->kesimpulan)
                        <div class="bg-green-50 rounded-xl p-4">
                            <h5 class="text-xs font-bold text-green-600 uppercase tracking-wider mb-2">Kesimpulan</h5>
                            <p class="text-sm text-green-800">{{ $radiology->kesimpulan }}</p>
                        </div>
                    @endif
                    
                    @if(!$radiology->interpretasi && !$radiology->kesimpulan)
                        <p class="text-gray-500 text-sm">Hasil pemeriksaan belum tersedia.</p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    @if($radiologyResults->hasPages())
        <div class="mt-6">
            {{ $radiologyResults->links() }}
        </div>
    @endif
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Hasil Radiologi</h3>
        <p class="text-gray-500">Anda belum memiliki riwayat pemeriksaan radiologi.</p>
    </div>
@endif
@endsection
