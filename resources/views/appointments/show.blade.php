@extends('layouts.app')

@section('title', 'Appointment Details')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-gray-800">Appointment Details</h2>
        <div class="space-x-2">
            @if($appointment->status == 'scheduled')
            <form action="{{ route('appointments.check-in', $appointment) }}" method="POST" class="inline">
                @csrf
                @method('PUT')
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md">
                    Check In
                </button>
            </form>
            @endif
            <a href="{{ route('appointments.edit', $appointment) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Edit
            </a>
        </div>
    </div>

    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="text-sm font-medium text-gray-500">Appointment Number</label>
            <p class="mt-1 text-lg text-gray-900">{{ $appointment->nomor_janji_temu }}</p>
        </div>
        <div>
            <label class="text-sm font-medium text-gray-500">Status</label>
            <p class="mt-1">
                <span class="px-3 py-1 text-sm rounded-full 
                    @if($appointment->status == 'selesai') bg-green-100 text-green-800
                    @elseif($appointment->status == 'dibatalkan') bg-red-100 text-red-800
                    @elseif($appointment->status == 'check_in') bg-blue-100 text-blue-800
                    @elseif($appointment->status == 'sedang_dilayani') bg-purple-100 text-purple-800
                    @else bg-yellow-100 text-yellow-800 @endif">
                    {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                </span>
            </p>
        </div>

        @if($appointment->status == 'check_in' && $appointment->queue_code)
        <div class="md:col-span-2 bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <div class="flex justify-between items-center">
                <div>
                    <label class="text-sm font-medium text-gray-600">Queue Number</label>
                    <p class="mt-1 text-4xl font-bold text-blue-600">{{ $appointment->queue_code }}</p>
                    <p class="text-sm text-gray-500 mt-1">Checked in at {{ $appointment->checked_in_at->format('H:i') }}</p>
                </div>
                <div>
                    <a href="{{ route('queue.ticket', $appointment) }}" target="_blank" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Print Queue Ticket
                    </a>
                </div>
            </div>
        </div>
        @endif
        <div>
            <label class="text-sm font-medium text-gray-500">Patient</label>
            <p class="mt-1 text-gray-900">
                <a href="{{ route('patients.show', $appointment->pasien) }}" class="text-blue-600 hover:underline">
                    {{ $appointment->pasien->nama_lengkap }} ({{ $appointment->pasien->mrn }})
                </a>
            </p>
        </div>
        <div>
            <label class="text-sm font-medium text-gray-500">Doctor</label>
            <p class="mt-1 text-gray-900">{{ $appointment->dokter->nama_lengkap }}</p>
            <p class="text-sm text-gray-500">{{ $appointment->dokter->departemen->nama }}</p>
        </div>
        <div>
            <label class="text-sm font-medium text-gray-500">Date & Time</label>
            <p class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($appointment->janjiTemu_date)->format('d F Y, H:i') }}</p>
        </div>
        <div>
            <label class="text-sm font-medium text-gray-500">Type</label>
            <p class="mt-1 text-gray-900">{{ ucfirst(str_replace('_', ' ', $appointment->type)) }}</p>
        </div>
        @if($appointment->checked_in_at)
        <div>
            <label class="text-sm font-medium text-gray-500">Check-in Time</label>
            <p class="mt-1 text-gray-900">{{ \Carbon\Carbon::parse($appointment->checked_in_at)->format('d F Y, H:i') }}</p>
        </div>
        @endif
        <div class="md:col-span-2">
            <label class="text-sm font-medium text-gray-500">Reason for Visit</label>
            <p class="mt-1 text-gray-900">{{ $appointment->reason ?: 'N/A' }}</p>
        </div>
        <div class="md:col-span-2">
            <label class="text-sm font-medium text-gray-500">Notes</label>
            <p class="mt-1 text-gray-900">{{ $appointment->catatan ?: 'N/A' }}</p>
        </div>
    </div>
</div>

@if($appointment->medicalRecord)
<div class="mt-6 bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-xl font-semibold text-gray-800">Medical Record</h3>
    </div>
    <div class="p-6">
        <a href="{{ route('medical-records.show', $appointment->medicalRecord) }}" class="text-blue-600 hover:underline">
            View Medical Record
        </a>
    </div>
</div>
@endif

@if($appointment->tagihan)
<div class="mt-6 bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-xl font-semibold text-gray-800">Invoice</h3>
    </div>
    <div class="p-6">
        <a href="{{ route('billing.show', $appointment->tagihan) }}" class="text-blue-600 hover:underline">
            View Invoice ({{ $appointment->tagihan->nomor_tagihan }})
        </a>
    </div>
</div>
@endif
@endsection
