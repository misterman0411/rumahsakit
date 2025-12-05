@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Vital Signs</h1>
            <p class="text-gray-600 mt-2">Update patient vital signs measurement</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('vital-signs.update', $vitalSign) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <!-- Patient Selection -->
                    <div>
                        <label for="pasien_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Patient <span class="text-red-500">*</span>
                        </label>
                        <select name="pasien_id" id="pasien_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Select Patient --</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('pasien_id', $vitalSign->pasien_id) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->no_rekam_medis }} - {{ $patient->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('pasien_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Medical Record (Optional) -->
                    <div>
                        <label for="rekam_medis_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Link to Medical Record (Optional)
                        </label>
                        <select name="rekam_medis_id" id="rekam_medis_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Select Medical Record --</option>
                            @foreach($medicalRecords as $record)
                                <option value="{{ $record->id }}" {{ old('rekam_medis_id', $vitalSign->medical_record_id) == $record->id ? 'selected' : '' }}>
                                    {{ $record->record_number }} - {{ $record->pasien->nama }} - {{ $record->created_at->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                        @error('rekam_medis_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Recording Date/Time -->
                    <div>
                        <label for="recorded_at" class="block text-sm font-semibold text-gray-700 mb-2">
                            Recording Date & Time
                        </label>
                        <input type="datetime-local" name="recorded_at" id="recorded_at" 
                            value="{{ old('recorded_at', $vitalSign->recorded_at->format('Y-m-d\TH:i')) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        @error('recorded_at')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vital Signs Grid -->
                    <div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Vital Signs Measurements</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Blood Pressure -->
                            <div>
                                <label for="blood_pressure" class="block text-sm font-medium text-gray-700 mb-2">
                                    Blood Pressure (mmHg)
                                </label>
                                <input type="text" name="blood_pressure" id="blood_pressure" 
                                    value="{{ old('blood_pressure', $vitalSign->blood_pressure) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="120/80">
                                @error('blood_pressure')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Temperature -->
                            <div>
                                <label for="temperature" class="block text-sm font-medium text-gray-700 mb-2">
                                    Temperature (°C)
                                </label>
                                <input type="number" step="0.1" name="temperature" id="temperature" 
                                    value="{{ old('temperature', $vitalSign->temperature) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="36.5">
                                @error('temperature')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Heart Rate -->
                            <div>
                                <label for="heart_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                    Heart Rate (bpm)
                                </label>
                                <input type="number" name="heart_rate" id="heart_rate" 
                                    value="{{ old('heart_rate', $vitalSign->heart_rate) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="80">
                                @error('heart_rate')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Respiratory Rate -->
                            <div>
                                <label for="respiratory_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                    Respiratory Rate (per minute)
                                </label>
                                <input type="number" name="respiratory_rate" id="respiratory_rate" 
                                    value="{{ old('respiratory_rate', $vitalSign->respiratory_rate) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="20">
                                @error('respiratory_rate')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Oxygen Saturation -->
                            <div>
                                <label for="oxygen_saturation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Oxygen Saturation (%)
                                </label>
                                <input type="number" name="oxygen_saturation" id="oxygen_saturation" 
                                    value="{{ old('oxygen_saturation', $vitalSign->oxygen_saturation) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="98">
                                @error('oxygen_saturation')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Weight -->
                            <div>
                                <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">
                                    Weight (kg)
                                </label>
                                <input type="number" step="0.1" name="weight" id="weight" 
                                    value="{{ old('weight', $vitalSign->weight) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="70.5">
                                @error('weight')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Height -->
                            <div>
                                <label for="height" class="block text-sm font-medium text-gray-700 mb-2">
                                    Height (cm)
                                </label>
                                <input type="number" step="0.1" name="height" id="height" 
                                    value="{{ old('height', $vitalSign->height) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                    placeholder="170.0">
                                @error('height')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">BMI will be calculated automatically</p>
                            </div>

                            @if($vitalSign->bmi)
                            <!-- Current BMI Display -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Current BMI
                                </label>
                                <div class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg">
                                    <span class="text-lg font-bold text-gray-900">{{ number_format($vitalSign->bmi, 1) }}</span>
                                    <span class="text-sm text-gray-600 ml-2">
                                        @if($vitalSign->bmi < 18.5) (Underweight)
                                        @elseif($vitalSign->bmi < 25) (Normal)
                                        @elseif($vitalSign->bmi < 30) (Overweight)
                                        @else (Obese)
                                        @endif
                                    </span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                            Notes
                        </label>
                        <textarea name="catatan" id="notes" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Any additional observations or notes">{{ old('notes', $vitalSign->catatan) }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('vital-signs.show', $vitalSign) }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Update Vital Signs
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
