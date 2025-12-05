@extends('layouts.app')

@section('title', 'Daily Logs - ' . $inpatient->pasien->nama)

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Daily Monitoring Logs</h2>
            <p class="text-sm text-gray-600 mt-1">
                Patient: <span class="font-medium">{{ $inpatient->pasien->nama }}</span> | 
                Room: <span class="font-medium">{{ $inpatient->ruangan->nomor_ruangan }} - {{ $inpatient->tempatTidur->nomor_tempat_tidur }}</span>
            </p>
        </div>
        @if(auth()->user()->hasAnyRole(['doctor', 'nurse', 'admin']))
        <a href="{{ route('inpatient.daily-logs.create', $inpatient) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
            + Add New Log
        </a>
        @endif
    </div>

    <!-- Stats Cards -->
    <div class="p-6 border-b border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="text-sm text-blue-600 font-medium">Total Logs</div>
                <div class="text-2xl font-bold text-blue-800">{{ $logs->total() }}</div>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="text-sm text-green-600 font-medium">Doctor Visits</div>
                <div class="text-2xl font-bold text-green-800">{{ $logs->where('type', 'doctor_visit')->count() }}</div>
            </div>
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                <div class="text-sm text-purple-600 font-medium">Nursing Care</div>
                <div class="text-2xl font-bold text-purple-800">{{ $logs->where('type', 'nursing_care')->count() }}</div>
            </div>
            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4">
                <div class="text-sm text-indigo-600 font-medium">Last 24 Hours</div>
                <div class="text-2xl font-bold text-indigo-800">{{ $logs->where('created_at', '>=', now()->subDay())->count() }}</div>
            </div>
        </div>
    </div>

    <!-- Timeline View -->
    <div class="p-6">
        @if($logs->count() > 0)
        <div class="space-y-4">
            @foreach($logs as $log)
            <div class="border-l-4 rounded-lg p-4 hover:shadow-md transition-shadow
                @if($log->type == 'doctor_visit') border-blue-500 bg-blue-50
                @elseif($log->type == 'nursing_care') border-green-500 bg-green-50
                @elseif($log->type == 'procedure') border-purple-500 bg-purple-50
                @else border-gray-500 bg-gray-50 @endif">
                
                <div class="flex justify-between items-start mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center
                            @if($log->type == 'doctor_visit') bg-blue-600
                            @elseif($log->type == 'nursing_care') bg-green-600
                            @elseif($log->type == 'procedure') bg-purple-600
                            @else bg-gray-600 @endif">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($log->type == 'doctor_visit')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                @elseif($log->type == 'nursing_care')
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                @endif
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">
                                {{ ucfirst(str_replace('_', ' ', $log->type)) }}
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $log->created_at->format('d M Y, H:i') }}
                                <span class="text-gray-400">•</span>
                                {{ $log->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('inpatient.daily-logs.show', [$inpatient, $log]) }}" class="text-blue-600 hover:text-blue-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </a>
                        @if(auth()->user()->hasAnyRole(['doctor', 'nurse', 'admin']))
                        <a href="{{ route('inpatient.daily-logs.edit', [$inpatient, $log]) }}" class="text-yellow-600 hover:text-yellow-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    @if($log->dokter)
                    <div>
                        <span class="font-medium text-gray-700">Doctor:</span>
                        <span class="text-gray-900">Dr. {{ $log->dokter->user->nama }}</span>
                    </div>
                    @endif
                    
                    @if($log->perawat)
                    <div>
                        <span class="font-medium text-gray-700">Nurse:</span>
                        <span class="text-gray-900">{{ $log->perawat->user->nama }}</span>
                    </div>
                    @endif

                    @if($log->vitalSign)
                    <div class="md:col-span-2">
                        <span class="font-medium text-gray-700">Vital Signs:</span>
                        <span class="text-gray-900">
                            BP: {{ $log->vitalSign->blood_pressure }}, 
                            HR: {{ $log->vitalSign->heart_rate }} bpm, 
                            Temp: {{ $log->vitalSign->temperature }}°C
                        </span>
                    </div>
                    @endif
                </div>

                @if($log->progress_notes)
                <div class="mt-3 pt-3 border-t border-gray-200">
                    <div class="font-medium text-gray-700 mb-1">Progress Notes:</div>
                    <div class="text-gray-900">{{ $log->progress_notes }}</div>
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $logs->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No logs yet</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating a new daily log.</p>
        </div>
        @endif
    </div>
</div>
@endsection
