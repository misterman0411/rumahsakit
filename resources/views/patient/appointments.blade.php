@extends('layouts.patient')

@section('title', 'Janji Temu Saya')
@section('subtitle', 'Daftar semua janji temu Anda')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div></div>
    <a href="{{ route('patient.appointments.book') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-medium hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
        </svg>
        Buat Janji Temu Baru
    </a>
</div>

@if(!$patient)
    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
        <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <h3 class="text-lg font-semibold text-yellow-800 mb-2">Data Pasien Belum Terdaftar</h3>
        <p class="text-yellow-700">Silakan hubungi bagian pendaftaran untuk mendaftarkan data pasien Anda.</p>
    </div>
@elseif($appointments->count() > 0)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tanggal & Waktu</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Dokter</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Poliklinik</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">No. Antrian</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($appointments as $appointment)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex flex-col items-center justify-center text-white mr-3">
                                        <span class="text-xs font-medium">{{ \Carbon\Carbon::parse($appointment->tanggal_janji)->format('M') }}</span>
                                        <span class="text-sm font-bold">{{ \Carbon\Carbon::parse($appointment->tanggal_janji)->format('d') }}</span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($appointment->tanggal_janji)->format('d M Y') }}</p>
                                        <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($appointment->tanggal_janji)->format('H:i') }} WIB</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-900">{{ $appointment->dokter->user->nama ?? '-' }}</p>
                                <p class="text-sm text-gray-500">{{ $appointment->dokter->spesialisasi ?? '' }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-700">{{ $appointment->departemen->nama ?? '-' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($appointment->nomor_antrian)
                                    <span class="inline-flex items-center justify-center w-10 h-10 bg-indigo-100 text-indigo-700 font-bold rounded-xl">
                                        {{ $appointment->nomor_antrian }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    @if($appointment->status === 'selesai') bg-green-100 text-green-700
                                    @elseif($appointment->status === 'dikonfirmasi') bg-blue-100 text-blue-700
                                    @elseif($appointment->status === 'check_in') bg-purple-100 text-purple-700
                                    @elseif($appointment->status === 'terjadwal') bg-yellow-100 text-yellow-700
                                    @elseif($appointment->status === 'dibatalkan') bg-red-100 text-red-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($appointments->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>
@else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
        </svg>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Janji Temu</h3>
        <p class="text-gray-500 mb-6">Anda belum memiliki riwayat janji temu. Buat janji temu pertama Anda sekarang!</p>
        <a href="{{ route('patient.appointments.book') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-medium hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Buat Janji Temu Pertama
        </a>
    </div>
@endif
@endsection
