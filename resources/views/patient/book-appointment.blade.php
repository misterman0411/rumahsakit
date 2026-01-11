@extends('layouts.patient')

@section('title', 'Booking Konsultasi')
@section('subtitle', 'Buat janji temu dengan dokter')

@section('content')
@if(!$patient)
    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 text-center">
        <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <h3 class="text-lg font-semibold text-yellow-800 mb-2">Data Pasien Belum Terdaftar</h3>
        <p class="text-yellow-700 mb-4">Anda perlu terdaftar sebagai pasien terlebih dahulu sebelum dapat membuat janji temu.</p>
        <p class="text-sm text-yellow-600">Silakan hubungi bagian pendaftaran rumah sakit untuk mendaftarkan data Anda.</p>
    </div>
@else
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-purple-50">
                <h3 class="text-lg font-bold text-gray-900">Form Booking Konsultasi</h3>
                <p class="text-sm text-gray-600 mt-1">Isi form berikut untuk membuat janji temu dengan dokter</p>
            </div>
            
            <form action="{{ route('patient.appointments.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                
                <!-- Department -->
                <div>
                    <label for="departemen_id" class="block text-sm font-semibold text-gray-700 mb-2">Poliklinik / Departemen</label>
                    <select name="departemen_id" id="departemen_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        <option value="">-- Pilih Poliklinik --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('departemen_id') == $dept->id ? 'selected' : '' }}>
                                {{ $dept->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('departemen_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Doctor -->
                <div>
                    <label for="dokter_id" class="block text-sm font-semibold text-gray-700 mb-2">Dokter</label>
                    <select name="dokter_id" id="dokter_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($doctors as $doctor)
                            <option value="{{ $doctor->id }}" 
                                    data-department="{{ $doctor->departemen_id }}"
                                    {{ old('dokter_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->user->nama ?? 'Dokter' }} - {{ $doctor->spesialisasi ?? '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('dokter_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label for="tanggal_janji" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kunjungan</label>
                    <input type="date" name="tanggal_janji" id="tanggal_janji" required
                           min="{{ date('Y-m-d') }}"
                           value="{{ old('tanggal_janji') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    @error('tanggal_janji')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time -->
                <div>
                    <label for="waktu_janji" class="block text-sm font-semibold text-gray-700 mb-2">Waktu Kunjungan</label>
                    <select name="waktu_janji" id="waktu_janji" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        <option value="">-- Pilih Waktu --</option>
                        <option value="08:00" {{ old('waktu_janji') == '08:00' ? 'selected' : '' }}>08:00 WIB</option>
                        <option value="08:30" {{ old('waktu_janji') == '08:30' ? 'selected' : '' }}>08:30 WIB</option>
                        <option value="09:00" {{ old('waktu_janji') == '09:00' ? 'selected' : '' }}>09:00 WIB</option>
                        <option value="09:30" {{ old('waktu_janji') == '09:30' ? 'selected' : '' }}>09:30 WIB</option>
                        <option value="10:00" {{ old('waktu_janji') == '10:00' ? 'selected' : '' }}>10:00 WIB</option>
                        <option value="10:30" {{ old('waktu_janji') == '10:30' ? 'selected' : '' }}>10:30 WIB</option>
                        <option value="11:00" {{ old('waktu_janji') == '11:00' ? 'selected' : '' }}>11:00 WIB</option>
                        <option value="13:00" {{ old('waktu_janji') == '13:00' ? 'selected' : '' }}>13:00 WIB</option>
                        <option value="13:30" {{ old('waktu_janji') == '13:30' ? 'selected' : '' }}>13:30 WIB</option>
                        <option value="14:00" {{ old('waktu_janji') == '14:00' ? 'selected' : '' }}>14:00 WIB</option>
                        <option value="14:30" {{ old('waktu_janji') == '14:30' ? 'selected' : '' }}>14:30 WIB</option>
                        <option value="15:00" {{ old('waktu_janji') == '15:00' ? 'selected' : '' }}>15:00 WIB</option>
                    </select>
                    @error('waktu_janji')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Complaint -->
                <div>
                    <label for="keluhan" class="block text-sm font-semibold text-gray-700 mb-2">Keluhan (Opsional)</label>
                    <textarea name="keluhan" id="keluhan" rows="4"
                              placeholder="Jelaskan keluhan atau gejala yang Anda rasakan..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors resize-none">{{ old('keluhan') }}</textarea>
                    @error('keluhan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <a href="{{ route('patient.appointments') }}" class="text-gray-600 hover:text-gray-800 font-medium">
                        ← Kembali
                    </a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
                        Buat Janji Temu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif

<script>
    // Filter doctors by department
    document.getElementById('departemen_id').addEventListener('change', function() {
        const departmentId = this.value;
        const doctorSelect = document.getElementById('dokter_id');
        const options = doctorSelect.querySelectorAll('option');
        
        options.forEach(option => {
            if (option.value === '') {
                option.style.display = 'block';
            } else if (departmentId === '' || option.dataset.department === departmentId) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
        
        doctorSelect.value = '';
    });
</script>
@endsection
