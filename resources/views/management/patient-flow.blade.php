@extends('layouts.app')

@section('title', 'Patient Flow')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3">
                <a href="{{ route('management.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Patient Flow</h1>
            </div>
            <p class="text-gray-600 mt-1">Patient visits, admissions & trends analysis</p>
        </div>
        
        <!-- Period Filter -->
        <div class="flex items-center gap-2">
            <span class="text-sm text-gray-600">Period:</span>
            <div class="flex rounded-lg overflow-hidden border border-gray-300">
                @foreach(['today' => 'Today', 'week' => 'Week', 'month' => 'Month', 'quarter' => 'Quarter', 'year' => 'Year'] as $key => $label)
                <a href="{{ route('management.patient-flow', ['period' => $key]) }}" 
                   class="px-4 py-2 text-sm {{ $period === $key ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Patients -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Patients</p>
                    <p class="text-3xl font-bold text-gray-900">{{ number_format($totalPatients) }}</p>
                </div>
            </div>
        </div>

        <!-- New Patients -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">New Patients ({{ ucfirst($period) }})</p>
                    <p class="text-3xl font-bold text-green-600">{{ number_format($newPatients) }}</p>
                </div>
            </div>
        </div>

        <!-- Appointments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Appointments ({{ ucfirst($period) }})</p>
                    <p class="text-3xl font-bold text-purple-600">{{ number_format($totalAppointments) }}</p>
                </div>
            </div>
        </div>

        <!-- Current Inpatients -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Current Inpatients</p>
                    <p class="text-3xl font-bold text-orange-600">{{ number_format($currentInpatients) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Appointments by Status -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Appointments by Status</h2>
            <div class="space-y-4">
                @php
                    $statusColors = [
                        'dijadwalkan' => ['bg' => 'bg-blue-500', 'text' => 'Scheduled'],
                        'dikonfirmasi' => ['bg' => 'bg-green-500', 'text' => 'Confirmed'],
                        'dalam_antrian' => ['bg' => 'bg-yellow-500', 'text' => 'In Queue'],
                        'sedang_diperiksa' => ['bg' => 'bg-purple-500', 'text' => 'In Progress'],
                        'selesai' => ['bg' => 'bg-emerald-500', 'text' => 'Completed'],
                        'dibatalkan' => ['bg' => 'bg-red-500', 'text' => 'Cancelled'],
                        'tidak_hadir' => ['bg' => 'bg-gray-500', 'text' => 'No Show'],
                    ];
                    $maxCount = $appointmentsByStatus->max('count') ?: 1;
                @endphp
                @forelse($appointmentsByStatus as $item)
                @php $itemWidth = "width: " . round(($item->count / $maxCount) * 100) . "%"; @endphp
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm text-gray-700">{{ $statusColors[$item->status]['text'] ?? $item->status }}</span>
                        <span class="text-sm font-bold">{{ $item->count }}</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="{{ $statusColors[$item->status]['bg'] ?? 'bg-gray-500' }} h-3 rounded-full" 
                             @style($itemWidth)></div>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-500 py-8">No appointment data</div>
                @endforelse
            </div>
        </div>

        <!-- Inpatient Statistics -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Inpatient Statistics</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 text-center">
                    <p class="text-3xl font-bold text-blue-700">{{ $inpatientStats['new_admissions'] }}</p>
                    <p class="text-sm text-blue-600 mt-1">New Admissions</p>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 text-center">
                    <p class="text-3xl font-bold text-green-700">{{ $inpatientStats['discharged'] }}</p>
                    <p class="text-sm text-green-600 mt-1">Discharged</p>
                </div>
                <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 text-center">
                    <p class="text-3xl font-bold text-orange-700">{{ $inpatientStats['current'] }}</p>
                    <p class="text-sm text-orange-600 mt-1">Current Patients</p>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 text-center">
                    <p class="text-3xl font-bold text-purple-700">{{ number_format($inpatientStats['avg_stay'], 1) }}</p>
                    <p class="text-sm text-purple-600 mt-1">Avg Stay (days)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Visits Chart -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Daily Visits Trend</h2>
        <div class="h-64 flex items-end justify-between gap-2">
            @php
                $maxVisits = collect($dailyVisits)->max('count') ?: 1;
            @endphp
            @forelse($dailyVisits as $day)
            @php $barHeight = "height: " . round(($day->count / $maxVisits) * 200) . "px"; @endphp
            <div class="flex-1 flex flex-col items-center">
                <div class="w-full bg-indigo-500 rounded-t transition-all hover:bg-indigo-600" 
                     @style($barHeight)
                     title="{{ $day->count }} visits"></div>
                <div class="text-xs text-gray-500 mt-2 transform -rotate-45 origin-top-left">
                    {{ \Carbon\Carbon::parse($day->date)->format('M d') }}
                </div>
                <div class="text-xs font-bold text-gray-700 mt-1">{{ $day->count }}</div>
            </div>
            @empty
            <div class="w-full text-center text-gray-500 py-8">No visit data available</div>
            @endforelse
        </div>
    </div>

    <!-- Room Occupancy -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Room Occupancy</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Room</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Department</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Total Beds</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Occupied</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600">Available</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600">Occupancy Rate</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($roomOccupancy as $room)
                    @php
                        $rate = $room->total_beds > 0 ? round($room->occupied_beds / $room->total_beds * 100) : 0;
                        $rateColor = $rate >= 90 ? 'red' : ($rate >= 70 ? 'yellow' : 'green');
                        $rateWidth = "width: {$rate}%";
                        $barClass = "bg-{$rateColor}-500";
                        $textClass = "text-{$rateColor}-600";
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-medium">{{ $room->nomor_ruangan }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $room->departemen ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">{{ $room->total_beds }}</td>
                        <td class="px-4 py-3 text-center font-semibold text-orange-600">{{ $room->occupied_beds }}</td>
                        <td class="px-4 py-3 text-center font-semibold text-green-600">{{ $room->total_beds - $room->occupied_beds }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                    <div class="{{ $barClass }} h-2 rounded-full" @style($rateWidth)></div>
                                </div>
                                <span class="text-sm font-bold {{ $textClass }}">{{ $rate }}%</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">No room data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
