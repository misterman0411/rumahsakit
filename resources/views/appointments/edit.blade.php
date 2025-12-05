@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Edit Janji Temu</h2>
                <a href="{{ route('appointments.index') }}" class="text-gray-600 hover:text-gray-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>
            </div>

            <form action="{{ route('appointments.update', $appointment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <!-- Patient Selection -->
                    <div>
                        <label for="pasien_id" class="block text-sm font-medium text-gray-700 mb-2">Pasien *</label>
                        <select name="pasien_id" id="pasien_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pasien_id') border-red-500 @enderror">
                            <option value="">Pilih Pasien</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ old('pasien_id', $appointment->pasien_id) == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->nama }} - {{ $patient->no_rekam_medis }}
                                </option>
                            @endforeach
                        </select>
                        @error('pasien_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department Selection -->
                    <div>
                        <label for="departemen_id" class="block text-sm font-medium text-gray-700 mb-2">Departemen *</label>
                        <select name="departemen_id" id="departemen_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('departemen_id') border-red-500 @enderror">
                            <option value="">Pilih Departemen</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('departemen_id', $appointment->departemen_id) == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('departemen_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Doctor Selection -->
                    <div>
                        <label for="dokter_id" class="block text-sm font-medium text-gray-700 mb-2">Dokter *</label>
                        <select name="dokter_id" id="dokter_id" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('dokter_id') border-red-500 @enderror">
                            <option value="">Pilih Dokter</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" data-department="{{ $doctor->departemen_id }}" 
                                    {{ old('dokter_id', $appointment->dokter_id) == $doctor->id ? 'selected' : '' }}>
                                    {{ $doctor->user->name }} - {{ $doctor->departemen->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('dokter_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Appointment Date -->
                    <div>
                        <label for="tanggal_janji" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Janji *</label>
                        <input type="date" name="tanggal_janji" id="tanggal_janji" required
                            value="{{ old('tanggal_janji', $appointment->tanggal_janji->format('Y-m-d')) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_janji') border-red-500 @enderror">
                        @error('tanggal_janji')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Appointment Time -->
                    <div>
                        <label for="waktu_janji" class="block text-sm font-medium text-gray-700 mb-2">Waktu Janji *</label>
                        <input type="time" name="waktu_janji" id="waktu_janji" required
                            value="{{ old('waktu_janji', $appointment->tanggal_janji->format('H:i')) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('waktu_janji') border-red-500 @enderror">
                        @error('waktu_janji')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Appointment Type -->
                    <div>
                        <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">Jenis Janji *</label>
                        <select name="jenis" id="jenis" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis') border-red-500 @enderror">
                            <option value="">Pilih Jenis</option>
                            <option value="rawat_jalan" {{ old('jenis', $appointment->jenis) == 'rawat_jalan' ? 'selected' : '' }}>Rawat Jalan</option>
                            <option value="darurat" {{ old('jenis', $appointment->jenis) == 'darurat' ? 'selected' : '' }}>Darurat</option>
                            <option value="rawat_inap" {{ old('jenis', $appointment->jenis) == 'rawat_inap' ? 'selected' : '' }}>Rawat Inap</option>
                            <option value="kontrol_ulang" {{ old('jenis', $appointment->jenis) == 'kontrol_ulang' ? 'selected' : '' }}>Kontrol Ulang</option>
                        </select>
                        @error('jenis')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select name="status" id="status" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                            <option value="terjadwal" {{ old('status', $appointment->status) == 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                            <option value="dikonfirmasi" {{ old('status', $appointment->status) == 'dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                            <option value="check_in" {{ old('status', $appointment->status) == 'check_in' ? 'selected' : '' }}>Check In</option>
                            <option value="sedang_dilayani" {{ old('status', $appointment->status) == 'sedang_dilayani' ? 'selected' : '' }}>Sedang Dilayani</option>
                            <option value="selesai" {{ old('status', $appointment->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ old('status', $appointment->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            <option value="tidak_hadir" {{ old('status', $appointment->status) == 'tidak_hadir' ? 'selected' : '' }}>Tidak Hadir</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reason -->
                    <div>
                        <label for="alasan" class="block text-sm font-medium text-gray-700 mb-2">Alasan Kunjungan *</label>
                        <textarea name="alasan" id="alasan" rows="3" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alasan') border-red-500 @enderror">{{ old('alasan', $appointment->alasan) }}</textarea>
                        @error('alasan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                        <textarea name="catatan" id="catatan" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('catatan') border-red-500 @enderror">{{ old('catatan', $appointment->catatan) }}</textarea>
                        @error('catatan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('appointments.index') }}" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Filter doctors by department
document.getElementById('departemen_id').addEventListener('change', function() {
    const departmentId = this.value;
    const doctorSelect = document.getElementById('dokter_id');
    const options = doctorSelect.querySelectorAll('option');
    
    options.forEach(option => {
        if (option.value === '') {
            option.style.display = 'block';
            return;
        }
        
        const doctorDepartment = option.getAttribute('data-department');
        if (!departmentId || doctorDepartment === departmentId) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });
    
    // Reset doctor selection if current selection is not in the filtered list
    const currentDoctor = doctorSelect.value;
    const currentOption = doctorSelect.querySelector(`option[value="${currentDoctor}"]`);
    if (currentOption && currentOption.style.display === 'none') {
        doctorSelect.value = '';
    }
});

// Trigger filter on page load
document.getElementById('departemen_id').dispatchEvent(new Event('change'));
</script>
@endsection
