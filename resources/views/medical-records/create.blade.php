@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Tambah Rekam Medis</h1>
            <p class="text-gray-600 mt-2">Catat pemeriksaan dan diagnosis pasien</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('medical-records.store') }}" method="POST">
                @csrf

                <div class="p-6 space-y-6">
                    <!-- Patient Selection -->
                    <div>
                        <label for="pasien_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Pasien <span class="text-red-500">*</span>
                        </label>
                        <select name="pasien_id" id="pasien_id" required
                            class="select2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            data-placeholder="-- Pilih Pasien --">
                            <option value="">-- Pilih Pasien --</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('pasien_id') == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->no_rekam_medis }} - {{ $patient->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('pasien_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Doctor Selection -->
                    <div>
                        <label for="dokter_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Dokter <span class="text-red-500">*</span>
                        </label>
                        <select name="dokter_id" id="dokter_id" required
                            class="select2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            data-placeholder="-- Pilih Dokter --">
                            <option value="">-- Pilih Dokter --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ old('dokter_id') == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->user->nama }} - {{ $doctor->spesialisasi }}
                                </option>
                            @endforeach
                        </select>
                        @error('dokter_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Appointment (Optional) -->
                    <div>
                        <label for="appointment_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Appointment (Opsional)
                        </label>
                        <select name="appointment_id" id="appointment_id"
                            class="select2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            data-placeholder="-- Pilih Appointment --">
                            <option value="">-- Pilih Appointment --</option>
                            @foreach($appointments as $appointment)
                                <option value="{{ $appointment->id }}" {{ old('appointment_id') == $appointment->id ? 'selected' : '' }}>
                                    {{ $appointment->nomor_janji_temu }} - {{ $appointment->pasien->nama }} - {{ $appointment->tanggal_janji->format('d/m/Y') }}
                                </option>
                            @endforeach
                        </select>
                        @error('appointment_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Symptoms/Anamnesis -->
                    <div>
                        <label for="keluhan" class="block text-sm font-semibold text-gray-700 mb-2">
                            Anamnesis/Keluhan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="keluhan" id="keluhan" rows="4" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Riwayat penyakit sekarang dan gejala yang dialami pasien">{{ old('keluhan') }}</textarea>
                        @error('keluhan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Vital Signs -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Vital Signs</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Tekanan Darah (mmHg)</label>
                                <input type="text" name="vital_signs[blood_pressure]" value="{{ old('vital_signs.blood_pressure') }}"
                                    placeholder="120/80"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Suhu (°C)</label>
                                <input type="text" name="vital_signs[temperature]" value="{{ old('vital_signs.temperature') }}"
                                    placeholder="36.5"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Nadi (bpm)</label>
                                <input type="text" name="vital_signs[heart_rate]" value="{{ old('vital_signs.heart_rate') }}"
                                    placeholder="80"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Pernapasan (per menit)</label>
                                <input type="text" name="vital_signs[respiratory_rate]" value="{{ old('vital_signs.respiratory_rate') }}"
                                    placeholder="20"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">SpO2 (%)</label>
                                <input type="text" name="vital_signs[oxygen_saturation]" value="{{ old('vital_signs.oxygen_saturation') }}"
                                    placeholder="98"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600 mb-1">Berat Badan (kg)</label>
                                <input type="text" name="vital_signs[weight]" value="{{ old('vital_signs.weight') }}"
                                    placeholder="70"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- ICD-10 Primary -->
                    <div>
                        <label for="icd10_primary" class="block text-sm font-semibold text-gray-700 mb-2">
                            Kode ICD-10 Diagnosis Primer
                        </label>
                        <input type="text" name="icd10_primary" id="icd10_primary" maxlength="10" value="{{ old('icd10_primary') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Contoh: J18.9">
                        <p class="text-xs text-gray-500 mt-1">Kode ICD-10 untuk diagnosis utama (maksimal 10 karakter)</p>
                        @error('icd10_primary')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ICD-10 Secondary -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kode ICD-10 Diagnosis Sekunder
                        </label>
                        <div id="icd10-secondary-container" class="space-y-2">
                            @if(old('icd10_secondary'))
                                @foreach(old('icd10_secondary') as $index => $code)
                                <div class="flex gap-2 icd10-secondary-item">
                                    <input type="text" name="icd10_secondary[]" maxlength="10" value="{{ $code }}"
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Contoh: E11.9">
                                    <button type="button" onclick="this.parentElement.remove()"
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                        Hapus
                                    </button>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" onclick="addIcd10Secondary()"
                            class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                            + Tambah Kode ICD-10 Sekunder
                        </button>
                        <p class="text-xs text-gray-500 mt-1">Kode ICD-10 untuk diagnosis tambahan/penyerta</p>
                    </div>

                    <!-- ICD-9 Procedures -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Kode ICD-9-CM Prosedur/Tindakan
                        </label>
                        <div id="icd9-procedures-container" class="space-y-2">
                            @if(old('icd9_procedures'))
                                @foreach(old('icd9_procedures') as $index => $code)
                                <div class="flex gap-2 icd9-procedure-item">
                                    <input type="text" name="icd9_procedures[]" maxlength="10" value="{{ $code }}"
                                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                        placeholder="Contoh: 99.04">
                                    <button type="button" onclick="this.parentElement.remove()"
                                        class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                                        Hapus
                                    </button>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" onclick="addIcd9Procedure()"
                            class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 text-sm">
                            + Tambah Kode ICD-9 Prosedur
                        </button>
                        <p class="text-xs text-gray-500 mt-1">Kode ICD-9-CM untuk prosedur/tindakan yang dilakukan</p>
                    </div>

                    <!-- Diagnosis -->
                    <div>
                        <label for="diagnosis" class="block text-sm font-semibold text-gray-700 mb-2">
                            Diagnosis Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea name="diagnosis" id="diagnosis" rows="4" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Diagnosis lengkap dalam bahasa medis">{{ old('diagnosis') }}</textarea>
                        @error('diagnosis')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Treatment Plan -->
                    <div>
                        <label for="treatment_plan" class="block text-sm font-semibold text-gray-700 mb-2">
                            Rencana Tindakan
                        </label>
                        <textarea name="treatment_plan" id="treatment_plan" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Rencana pengobatan dan tindakan yang akan dilakukan">{{ old('treatment_plan') }}</textarea>
                        @error('treatment_plan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Recommendations -->
                    <div>
                        <label for="recommendations" class="block text-sm font-semibold text-gray-700 mb-2">
                            Rekomendasi & Edukasi
                        </label>
                        <textarea name="recommendations" id="recommendations" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Rekomendasi untuk pasien, edukasi kesehatan, atau rujukan">{{ old('recommendations') }}</textarea>
                        @error('recommendations')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                            Catatan Tambahan
                        </label>
                        <textarea name="catatan" id="notes" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Catatan tambahan jika ada">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('medical-records.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Simpan Rekam Medis
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addIcd10Secondary() {
    const container = document.getElementById('icd10-secondary-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2 icd10-secondary-item';
    div.innerHTML = `
        <input type="text" name="icd10_secondary[]" maxlength="10"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
            placeholder="Contoh: E11.9">
        <button type="button" onclick="this.parentElement.remove()"
            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            Hapus
        </button>
    `;
    container.appendChild(div);
}

function addIcd9Procedure() {
    const container = document.getElementById('icd9-procedures-container');
    const div = document.createElement('div');
    div.className = 'flex gap-2 icd9-procedure-item';
    div.innerHTML = `
        <input type="text" name="icd9_procedures[]" maxlength="10"
            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
            placeholder="Contoh: 99.04">
        <button type="button" onclick="this.parentElement.remove()"
            class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
            Hapus
        </button>
    `;
    container.appendChild(div);
}
</script>
@endsection
