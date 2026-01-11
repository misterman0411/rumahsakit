@extends('layouts.patient')

@section('title', 'Hasil Laboratorium')
@section('subtitle', 'Riwayat pemeriksaan laboratorium Anda')

@section('content')
@if(!$patient)
    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
        <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <h3 class="text-lg font-semibold text-yellow-800 mb-2">Data Pasien Belum Terdaftar</h3>
        <p class="text-yellow-700">Silakan hubungi bagian pendaftaran untuk mendaftarkan data pasien Anda.</p>
    </div>
@elseif($labResults->count() > 0)
    <div class="space-y-4">
        @foreach($labResults as $lab)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-xl flex items-center justify-center text-white mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $lab->jenisTes->nama ?? 'Tes Lab' }}</h4>
                            <p class="text-sm text-gray-500">{{ $lab->created_at->format('d F Y') }} • Dr. {{ $lab->dokter->user->nama ?? '-' }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        @if($lab->status === 'completed') bg-green-100 text-green-700
                        @elseif($lab->status === 'in_progress') bg-blue-100 text-blue-700
                        @elseif($lab->status === 'ordered') bg-yellow-100 text-yellow-700
                        @else bg-gray-100 text-gray-700
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $lab->status)) }}
                    </span>
                </div>
                
                @if($lab->results && $lab->results->count() > 0)
                    <div class="p-6">
                        <h5 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Hasil Pemeriksaan</h5>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="text-left py-2 font-semibold text-gray-600">Parameter</th>
                                        <th class="text-left py-2 font-semibold text-gray-600">Hasil</th>
                                        <th class="text-left py-2 font-semibold text-gray-600">Nilai Normal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lab->results as $result)
                                        <tr class="border-b border-gray-100">
                                            <td class="py-2 text-gray-900">{{ $result->parameter ?? '-' }}</td>
                                            <td class="py-2 font-medium {{ ($result->is_abnormal ?? false) ? 'text-red-600' : 'text-gray-900' }}">
                                                {{ $result->nilai ?? '-' }} {{ $result->satuan ?? '' }}
                                            </td>
                                            <td class="py-2 text-gray-500">{{ $result->nilai_normal ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
    @if($labResults->hasPages())
        <div class="mt-6">
            {{ $labResults->links() }}
        </div>
    @endif
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Hasil Lab</h3>
        <p class="text-gray-500">Anda belum memiliki riwayat pemeriksaan laboratorium.</p>
    </div>
@endif
@endsection
