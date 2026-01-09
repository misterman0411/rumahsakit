@extends('layouts.app')

@section('title', 'Rawat Inap Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('inpatient.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-4 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>
        <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Rawat Inap Baru</h2>
        <p class="text-gray-500 mt-1">Input data rawat inap pasien</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <form method="POST" action="{{ route('inpatient.store') }}" class="p-8">
            @csrf

            <!-- Patient Selection -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pasien <span class="text-red-500">*</span></label>
                <select name="pasien_id" required class="select2 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('pasien_id') border-red-500 @enderror" data-placeholder="Pilih Pasien">
                    <option value="">Pilih Pasien</option>
                    @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ old('pasien_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->nama }} - {{ $patient->no_rekam_medis }}
                    </option>
                    @endforeach
                </select>
                @error('pasien_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Doctor Selection -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Dokter Penanggung Jawab <span class="text-red-500">*</span></label>
                <select name="dokter_id" required class="select2 w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('dokter_id') border-red-500 @enderror" data-placeholder="Pilih Dokter">
                    <option value="">Pilih Dokter</option>
                    @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ old('dokter_id') == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->user->nama }} - {{ $doctor->spesialisasi }}
                    </option>
                    @endforeach
                </select>
                @error('dokter_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Room Selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kamar <span class="text-red-500">*</span></label>
                    <select name="ruangan_id" id="ruangan_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('ruangan_id') border-red-500 @enderror">
                        <option value="">Pilih Kamar</option>
                        @foreach($rooms as $room)
                        <option value="{{ $room->id }}" data-beds="{{ json_encode($room->tempatTidurs) }}" {{ old('ruangan_id') == $room->id ? 'selected' : '' }}>
                            {{ $room->nomor_ruangan }} - {{ $room->ruangan_type }}
                        </option>
                        @endforeach
                    </select>
                    @error('ruangan_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bed Selection -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tempat Tidur <span class="text-red-500">*</span></label>
                    <select name="tempat_tidur_id" id="tempat_tidur_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('tempat_tidur_id') border-red-500 @enderror">
                        <option value="">Pilih Tempat Tidur</option>
                    </select>
                    @error('tempat_tidur_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <!-- Admission Date -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Masuk <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="tanggal_masuk" value="{{ old('tanggal_masuk', now()->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('admission_date') border-red-500 @enderror">
                    @error('admission_date')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Admission Type -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Rawat Inap <span class="text-red-500">*</span></label>
                    <select name="jenis_masuk" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('jenis_masuk') border-red-500 @enderror">
                        <option value="darurat" {{ old('jenis_masuk') == 'darurat' ? 'selected' : '' }}>Darurat (Emergency)</option>
                        <option value="elektif" {{ old('jenis_masuk') == 'elektif' ? 'selected' : '' }}>Elektif (Scheduled)</option>
                    </select>
                    @error('admission_type')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Reason -->
            <div class="mb-8">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Rawat Inap <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="4" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('reason') border-red-500 @enderror">{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('inpatient.index') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors font-semibold">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all font-semibold">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('room_id').addEventListener('change', function() {
    const bedSelect = document.getElementById('bed_id');
    bedSelect.innerHTML = '<option value="">Pilih Tempat Tidur</option>';
    
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
        const beds = JSON.parse(selectedOption.dataset.beds);
        beds.forEach(bed => {
            if (bed.status === 'tersedia') {
                const option = document.createElement('option');
                option.value = bed.id;
                option.textContent = `Bed ${bed.bed_number}`;
                bedSelect.appendChild(option);
            }
        });
    }
});

// Trigger change if room already selected (for old input)
if (document.getElementById('room_id').value) {
    document.getElementById('room_id').dispatchEvent(new Event('change'));
}
</script>
@endsection
