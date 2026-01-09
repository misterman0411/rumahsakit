@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Queue Display Links (Front Office & Admin) -->
@if(auth()->user()->hasAnyRole(['front_office', 'admin']))
<div class="bg-linear-to-r from-blue-600 to-indigo-700 rounded-xl shadow-lg p-6 mb-8 text-white">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold">Queue Display System</h3>
                <p class="text-blue-100 text-sm">Monitor antrian poliklinik secara real-time</p>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
        @php
            $departments = \App\Models\Department::orderBy('nama')->get();
        @endphp
        @foreach($departments as $dept)
        @php
            // Get queue data untuk department ini
            $today_appointments = \App\Models\Appointment::where('departemen_id', $dept->id)
                ->whereDate('tanggal_janji', today())
                ->whereIn('status', ['confirmed', 'in_progress', 'check_in'])
                ->orderBy('nomor_antrian')
                ->get();
            
            $current_queue = $today_appointments->where('status', 'in_progress')->first();
            $waiting_count = $today_appointments->whereIn('status', ['confirmed', 'check_in'])->count();
            $next_queues = $today_appointments->where('status', 'check_in')->take(2);
        @endphp
        <div class="bg-white/10 backdrop-blur-sm rounded-lg p-4 border border-white/20 hover:bg-white/15 transition-all">
            <div class="flex justify-between items-start mb-3">
                <div>
                    <div class="text-sm font-medium text-blue-100">Poliklinik</div>
                    <div class="text-lg font-bold mt-1">{{ $dept->nama }}</div>
                </div>
                <a href="{{ route('queue.display', $dept->id) }}" target="_blank" 
                   class="text-white/80 hover:text-white transition-colors" title="Buka Display">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </a>
            </div>
            
            @if($current_queue)
            <div class="bg-green-500/20 rounded-md px-3 py-2 mb-2 border border-green-300/30">
                <div class="text-xs text-green-100 font-medium">Sedang Dilayani</div>
                <div class="text-2xl font-bold text-white">{{ $current_queue->nomor_antrian }}</div>
                <div class="text-xs text-green-100 truncate">{{ $current_queue->pasien->nama }}</div>
            </div>
            @else
            <div class="bg-white/5 rounded-md px-3 py-2 mb-2 border border-white/10">
                <div class="text-xs text-blue-200">Belum Ada Antrian</div>
            </div>
            @endif
            
            <div class="flex items-center justify-between text-xs text-blue-100 pt-2 border-t border-white/10">
                <span>Menunggu: <strong>{{ $waiting_count }}</strong></span>
                <span>Total: <strong>{{ $today_appointments->count() }}</strong></span>
            </div>
            
            @if($next_queues->count() > 0)
            <div class="mt-2 pt-2 border-t border-white/10">
                <div class="text-xs text-blue-200 mb-1">Antrian Berikutnya:</div>
                @foreach($next_queues as $next)
                <div class="text-xs text-white/80 flex items-center gap-2">
                    <span class="font-bold">{{ $next->nomor_antrian }}</span>
                    <span class="truncate">{{ $next->pasien->nama }}</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach
    </div>
    <div class="mt-4 pt-4 border-t border-white/20 text-sm text-blue-100">
        💡 Tip: Buka link di tab baru untuk ditampilkan di layar TV ruang tunggu (auto-refresh setiap 10 detik)
    </div>
</div>
@endif

<!-- Statistics -->
@if(isset($stats) && count($stats) > 0)
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    @foreach($stats as $label => $value)
    <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 p-6 border border-gray-200 hover:border-indigo-200">
        <div class="flex items-center justify-between mb-4">
            <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ ucwords(str_replace('_', ' ', $label)) }}</div>
            <div class="w-11 h-11 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
        <div class="text-4xl font-bold bg-linear-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
            {{ strpos($label, 'revenue') !== false ? 'Rp ' . number_format($value, 0, ',', '.') : $value }}
        </div>
    </div>
    @endforeach
</div>
@endif

<!-- Doctor Schedule -->
@if($role === 'doctor' && isset($appointments) && count($appointments) > 0)
<div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8 border border-gray-200">
    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-indigo-50 via-purple-50 to-white">
        <h3 class="text-lg font-bold text-gray-900 flex items-center">
            <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            Jadwal Hari Ini
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Pasien</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($appointments as $apt)
                <tr class="hover:bg-indigo-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ \Carbon\Carbon::parse($apt->janjiTemu_date)->format('H:i') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $apt->pasien->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($apt->type) }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $apt->status === 'completed' ? 'bg-green-100 text-green-800' : ($apt->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ ucfirst($apt->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Front Office Recent Patients -->
@if($role === 'front_office' && isset($recent_patients) && count($recent_patients) > 0)
<div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-indigo-50 via-purple-50 to-white">
        <h3 class="text-lg font-bold text-gray-900 flex items-center">
            <div class="w-8 h-8 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            Pasien Terbaru
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">No. RM</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Telepon</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($recent_patients as $patient)
                <tr class="hover:bg-indigo-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $patient->no_rekam_medis }}</td>
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $patient->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $patient->telepon }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $patient->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($patient->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Welcome Message -->
@if((!isset($stats) || count($stats) === 0) && 
    (!isset($appointments) || count($appointments) === 0) && 
    (!isset($recent_patients) || count($recent_patients) === 0))
<div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-200">
    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-xl shadow-indigo-200">
        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
        </svg>
    </div>
    <h3 class="text-2xl font-bold text-gray-900 mb-3">Selamat Datang di MediCare Hospital System</h3>
    <p class="text-gray-500 mb-8 text-lg">Gunakan menu di sidebar untuk navigasi ke modul yang Anda butuhkan</p>
    <div class="flex justify-center space-x-4">
        @can('manage-patients')
        <a href="{{ route('patients.index') }}" class="flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:scale-105 transition-all duration-200 font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span>Kelola Pasien</span>
        </a>
        @endcan
        @if(auth()->user()->hasAnyRole(['front_office', 'admin']))
        <a href="{{ route('appointments.create') }}" class="flex items-center space-x-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-xl shadow-lg shadow-indigo-200 hover:shadow-xl hover:scale-105 transition-all duration-200 font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>Buat Appointment</span>
        </a>
        @endif
    </div>
</div>
@endif
@endsection
