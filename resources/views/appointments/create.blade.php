@extends('layouts.app')

@section('title', 'Create Appointment')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800">Create New Appointment</h2>
    </div>

    <form action="{{ route('appointments.store') }}" method="POST" class="p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Patient -->
            <div class="md:col-span-2">
                <label for="pasien_id" class="block text-sm font-medium text-gray-700">Patient *</label>
                <select name="pasien_id" id="pasien_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ old('pasien_id', request('patient_id')) == $patient->id ? 'selected' : '' }}>
                            {{ $patient->no_rekam_medis }} - {{ $patient->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Doctor -->
            <div class="md:col-span-2">
                <label for="dokter_id" class="block text-sm font-medium text-gray-700">Doctor *</label>
                <select name="dokter_id" id="dokter_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Doctor</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('dokter_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->user->nama }} - {{ $doctor->departemen->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Appointment Date & Time -->
            <div>
                <label for="tanggal_janji" class="block text-sm font-medium text-gray-700">Tanggal *</label>
                <input type="date" name="tanggal_janji" id="tanggal_janji" required value="{{ old('tanggal_janji') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="waktu_janji" class="block text-sm font-medium text-gray-700">Waktu *</label>
                <input type="time" name="waktu_janji" id="waktu_janji" required value="{{ old('waktu_janji') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Appointment Type -->
            <div>
                <label for="jenis" class="block text-sm font-medium text-gray-700">Jenis *</label>
                <select name="jenis" id="jenis" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Jenis</option>
                    <option value="rawat_jalan" {{ old('jenis') == 'rawat_jalan' ? 'selected' : '' }}>Rawat Jalan</option>
                    <option value="kontrol_ulang" {{ old('jenis') == 'kontrol_ulang' ? 'selected' : '' }}>Kontrol Ulang</option>
                    <option value="darurat" {{ old('jenis') == 'darurat' ? 'selected' : '' }}>Darurat</option>
                    <option value="rawat_inap" {{ old('jenis') == 'rawat_inap' ? 'selected' : '' }}>Rawat Inap</option>
                </select>
            </div>

            <!-- Reason -->
            <div class="md:col-span-2">
                <label for="alasan" class="block text-sm font-medium text-gray-700">Alasan Kunjungan *</label>
                <textarea name="alasan" id="alasan" rows="3" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('alasan') }}</textarea>
            </div>

            <!-- Notes -->
            <div class="md:col-span-2">
                <label for="catatan" class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea name="catatan" id="catatan" rows="2"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('catatan') }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('appointments.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Create Appointment
            </button>
        </div>
    </form>
</div>
@endsection
