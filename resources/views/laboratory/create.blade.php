@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Order Laboratorium Baru</h1>
            <p class="text-gray-600 mt-2">Buat order pemeriksaan laboratorium untuk pasien</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('laboratory.store') }}" method="POST">
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
                            Dokter Pengirim <span class="text-red-500">*</span>
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

                    <!-- Test Type Selection -->
                    <div>
                        <label for="jenis_tes_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Jenis Pemeriksaan <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_tes_id" id="jenis_tes_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">-- Pilih Jenis Pemeriksaan --</option>
                            @foreach($testTypes as $jenisTes)
                                <option value="{{ $jenisTes->id }}" {{ old('jenis_tes_id') == $jenisTes->id ? 'selected' : '' }}>
                                    {{ $jenisTes->nama }} - Rp {{ number_format($jenisTes->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_tes_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Clinical Info -->
                    <div>
                        <label for="clinical_info" class="block text-sm font-semibold text-gray-700 mb-2">
                            Informasi Klinis
                        </label>
                        <textarea name="clinical_info" id="clinical_info" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Riwayat klinis, indikasi pemeriksaan, dll">{{ old('clinical_info') }}</textarea>
                        @error('clinical_info')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('laboratory.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Buat Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
