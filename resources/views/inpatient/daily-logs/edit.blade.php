@extends('layouts.app')

@section('title', 'Edit Daily Log')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Daily Log</h2>
        <p class="text-sm text-gray-600 mt-1">
            Patient: <span class="font-medium">{{ $inpatient->pasien->nama }}</span>
        </p>
    </div>

    <form action="{{ route('inpatient.daily-logs.update', [$inpatient, $log]) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Type Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Log Type <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach(['doctor_visit' => 'Doctor Visit', 'nursing_care' => 'Nursing Care', 'procedure' => 'Procedure', 'general' => 'General'] as $value => $label)
                    <label class="relative flex cursor-pointer rounded-lg border p-4 hover:border-blue-500 transition-colors {{ $log->type == $value ? 'border-blue-500 bg-blue-50' : '' }}">
                        <input type="radio" name="type" value="{{ $value }}" class="sr-only" {{ $log->type == $value ? 'checked' : '' }} required>
                        <span class="flex flex-1">
                            <span class="flex flex-col">
                                <span class="block text-sm font-medium text-gray-900">{{ $label }}</span>
                            </span>
                        </span>
                        <svg class="h-5 w-5 text-blue-600 {{ $log->type == $value ? '' : 'hidden' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                    </label>
                    @endforeach
                </div>
                @error('type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Doctor Selection -->
            @if(auth()->user()->role->nama == 'doctor' || auth()->user()->hasAnyRole(['admin']))
            <div id="doctor-field">
                <label class="block text-sm font-medium text-gray-700 mb-2">Doctor</label>
                <select name="dokter_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select Doctor</option>
                    @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ $log->dokter_id == $doctor->id ? 'selected' : '' }}>
                        Dr. {{ $doctor->user->nama }} - {{ $doctor->spesialisasi }}
                    </option>
                    @endforeach
                </select>
                @error('dokter_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @endif

            <!-- Nurse Selection -->
            @if(auth()->user()->role->nama == 'nurse' || auth()->user()->hasAnyRole(['admin']))
            <div id="nurse-field">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nurse</label>
                <select name="perawat_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select Nurse</option>
                    @foreach($nurses as $nurse)
                    <option value="{{ $nurse->id }}" {{ $log->perawat_id == $nurse->id ? 'selected' : '' }}>
                        {{ $nurse->user->nama }}
                    </option>
                    @endforeach
                </select>
                @error('perawat_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            @endif

            <!-- Vital Sign Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Link to Vital Sign (Optional)</label>
                <select name="vital_sign_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select Vital Sign Record</option>
                    @foreach($vitalSigns as $vs)
                    <option value="{{ $vs->id }}" {{ $log->vital_sign_id == $vs->id ? 'selected' : '' }}>
                        {{ $vs->recorded_at->format('d M Y H:i') }} - 
                        BP: {{ $vs->blood_pressure }}, HR: {{ $vs->heart_rate }}, Temp: {{ $vs->temperature }}°C
                    </option>
                    @endforeach
                </select>
                @error('vital_sign_id')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Progress Notes -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Progress Notes <span class="text-red-500">*</span></label>
                <textarea name="progress_notes" rows="4" required 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter detailed progress notes...">{{ old('progress_notes', $log->progress_notes) }}</textarea>
                @error('progress_notes')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Doctor Orders -->
            <div id="doctor-orders-field">
                <label class="block text-sm font-medium text-gray-700 mb-2">Doctor Orders</label>
                <textarea name="doctor_orders" rows="3" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter doctor's orders...">{{ old('doctor_orders', $log->dokter_orders) }}</textarea>
                @error('doctor_orders')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nurse Notes -->
            <div id="nurse-notes-field">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nurse Notes</label>
                <textarea name="nurse_notes" rows="3" 
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter nursing notes...">{{ old('nurse_notes', $log->perawat_notes) }}</textarea>
                @error('nurse_notes')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('inpatient.daily-logs.show', [$inpatient, $log]) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Update Log
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeRadios = document.querySelectorAll('input[name="type"]');

    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            typeRadios.forEach(r => {
                r.parentElement.classList.remove('border-blue-500', 'bg-blue-50');
                r.parentElement.querySelector('svg').classList.add('hidden');
            });
            if(this.checked) {
                this.parentElement.classList.add('border-blue-500', 'bg-blue-50');
                this.parentElement.querySelector('svg').classList.remove('hidden');
            }
        });
    });
});
</script>
@endsection
