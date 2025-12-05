@extends('layouts.app')

@section('title', 'Daily Log Details')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Daily Log Details</h2>
            <p class="text-sm text-gray-600 mt-1">
                {{ $log->created_at->format('d F Y, H:i') }}
            </p>
        </div>
        <div class="flex space-x-2">
            @if(auth()->user()->hasAnyRole(['doctor', 'nurse', 'admin']))
            <a href="{{ route('inpatient.daily-logs.edit', [$inpatient, $log]) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md">
                Edit
            </a>
            @endif
            <a href="{{ route('inpatient.daily-logs.index', $inpatient) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                Back
            </a>
        </div>
    </div>

    <div class="p-6">
        <!-- Type Badge -->
        <div class="mb-6">
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                @if($log->type == 'doctor_visit') bg-blue-100 text-blue-800
                @elseif($log->type == 'nursing_care') bg-green-100 text-green-800
                @elseif($log->type == 'procedure') bg-purple-100 text-purple-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ ucfirst(str_replace('_', ' ', $log->type)) }}
            </span>
        </div>

        <!-- Patient Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 p-4 bg-gray-50 rounded-lg">
            <div>
                <label class="text-sm font-medium text-gray-500">Patient</label>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $inpatient->pasien->nama }}</p>
                <p class="text-sm text-gray-600">{{ $inpatient->pasien->no_rekam_medis }}</p>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-500">Room & Bed</label>
                <p class="mt-1 text-lg font-semibold text-gray-900">
                    {{ $inpatient->ruangan->nomor_ruangan }} - {{ $inpatient->tempatTidur->nomor_tempat_tidur }}
                </p>
                <p class="text-sm text-gray-600">{{ $inpatient->ruangan->ruangan_type }}</p>
            </div>
        </div>

        <!-- Staff Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            @if($log->dokter)
            <div class="border border-blue-200 bg-blue-50 rounded-lg p-4">
                <label class="text-sm font-medium text-blue-700">Doctor</label>
                <p class="mt-1 text-lg font-semibold text-gray-900">Dr. {{ $log->dokter->user->nama }}</p>
                <p class="text-sm text-gray-600">{{ $log->dokter->spesialisasi }}</p>
            </div>
            @endif

            @if($log->perawat)
            <div class="border border-green-200 bg-green-50 rounded-lg p-4">
                <label class="text-sm font-medium text-green-700">Nurse</label>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ $log->perawat->user->nama }}</p>
            </div>
            @endif
        </div>

        <!-- Vital Signs -->
        @if($log->vitalSign)
        <div class="mb-6 border border-indigo-200 bg-indigo-50 rounded-lg p-4">
            <label class="text-sm font-medium text-indigo-700 mb-3 block">Vital Signs</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <div class="text-xs text-gray-600">Blood Pressure</div>
                    <div class="text-lg font-semibold text-gray-900">{{ $log->vitalSign->blood_pressure }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-600">Heart Rate</div>
                    <div class="text-lg font-semibold text-gray-900">{{ $log->vitalSign->heart_rate }} bpm</div>
                </div>
                <div>
                    <div class="text-xs text-gray-600">Temperature</div>
                    <div class="text-lg font-semibold text-gray-900">{{ $log->vitalSign->temperature }}°C</div>
                </div>
                <div>
                    <div class="text-xs text-gray-600">Respiratory Rate</div>
                    <div class="text-lg font-semibold text-gray-900">{{ $log->vitalSign->respiratory_rate ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
        @endif

        <!-- Progress Notes -->
        @if($log->progress_notes)
        <div class="mb-6">
            <label class="text-sm font-medium text-gray-700 mb-2 block">Progress Notes</label>
            <div class="bg-white border border-gray-200 rounded-lg p-4">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $log->progress_notes }}</p>
            </div>
        </div>
        @endif

        <!-- Doctor Orders -->
        @if($log->dokter_orders)
        <div class="mb-6">
            <label class="text-sm font-medium text-gray-700 mb-2 block">Doctor Orders</label>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $log->dokter_orders }}</p>
            </div>
        </div>
        @endif

        <!-- Nurse Notes -->
        @if($log->perawat_notes)
        <div class="mb-6">
            <label class="text-sm font-medium text-gray-700 mb-2 block">Nurse Notes</label>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <p class="text-gray-900 whitespace-pre-wrap">{{ $log->perawat_notes }}</p>
            </div>
        </div>
        @endif

        <!-- Metadata -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                <div>
                    <span class="font-medium">Created:</span> {{ $log->created_at->format('d M Y, H:i') }}
                </div>
                <div>
                    <span class="font-medium">Updated:</span> {{ $log->updated_at->format('d M Y, H:i') }}
                </div>
                <div>
                    <span class="font-medium">Time Ago:</span> {{ $log->created_at->diffForHumans() }}
                </div>
            </div>
        </div>

        <!-- Actions -->
        @if(auth()->user()->hasAnyRole(['doctor', 'nurse', 'admin']))
        <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between items-center">
            <form action="{{ route('inpatient.daily-logs.destroy', [$inpatient, $log]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this log?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                    Delete Log
                </button>
            </form>
            
            <a href="{{ route('inpatient.daily-logs.edit', [$inpatient, $log]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Edit Log
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
