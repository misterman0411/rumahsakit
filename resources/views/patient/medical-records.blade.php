@extends('layouts.patient')

@section('title', 'Rekam Medis')
@section('subtitle', 'Riwayat catatan medis Anda')

@section('content')
@if(!$patient)
    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
        <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <h3 class="text-lg font-semibold text-yellow-800 mb-2">Data Pasien Belum Terdaftar</h3>
        <p class="text-yellow-700">Silakan hubungi bagian pendaftaran untuk mendaftarkan data pasien Anda.</p>
    </div>
@elseif($medicalRecords->count() > 0)
    <div class="space-y-4">
        @foreach($medicalRecords as $record)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex flex-col items-center justify-center text-white mr-4">
                                <span class="text-xs font-medium">{{ \Carbon\Carbon::parse($record->tanggal_kunjungan)->format('M') }}</span>
                                <span class="text-lg font-bold">{{ \Carbon\Carbon::parse($record->tanggal_kunjungan)->format('d') }}</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900">{{ $record->dokter->user->nama ?? 'Dokter' }}</h4>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($record->tanggal_kunjungan)->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Keluhan</h5>
                            <p class="text-sm text-gray-700">{{ $record->keluhan ?? '-' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Diagnosis</h5>
                            <p class="text-sm text-gray-700">{{ $record->diagnosis ?? '-' }}</p>
                        </div>
                    </div>
                    
                    @if($record->catatan)
                        <div class="mt-4 bg-blue-50 rounded-xl p-4">
                            <h5 class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-2">Catatan Dokter</h5>
                            <p class="text-sm text-blue-800">{{ $record->catatan }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    
    @if($medicalRecords->hasPages())
        <div class="mt-6">
            {{ $medicalRecords->links() }}
        </div>
    @endif
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Rekam Medis</h3>
        <p class="text-gray-500">Anda belum memiliki riwayat rekam medis.</p>
    </div>
@endif
@endsection
