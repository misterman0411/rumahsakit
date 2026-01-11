@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Buat Resep Obat Baru</h1>
            <p class="text-gray-600 mt-2">Tulis resep obat untuk pasien</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('prescriptions.store') }}" method="POST">
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
                    @if($currentDoctor)
                        <!-- Hidden field untuk dokter yang sedang login -->
                        <input type="hidden" name="dokter_id" value="{{ $currentDoctor->id }}">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Dokter</label>
                            <p class="text-gray-800 font-medium">{{ $currentDoctor->user->nama }} - {{ $currentDoctor->spesialisasi }}</p>
                        </div>
                    @else
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
                    @endif

                    <!-- Medications -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Daftar Obat <span class="text-red-500">*</span>
                        </label>
                        <div id="medicationsContainer" class="space-y-4">
                            <div class="medication-item border border-gray-200 rounded-lg p-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Obat</label>
                                        <select name="items[0][obat_id]" required
                                            class="select2 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 medication-select"
                                            data-placeholder="-- Pilih Obat --">
                                            <option value="">-- Pilih Obat --</option>
                                            @foreach($medications as $medication)
                                                <option value="{{ $medication->id }}" data-price="{{ $medication->harga }}">
                                                    {{ $medication->nama }} - Rp {{ number_format($medication->harga, 0, ',', '.') }} (Stok: {{ $medication->stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah</label>
                                        <input type="number" name="items[0][jumlah]" min="1" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Dosis</label>
                                        <input type="text" name="items[0][dosis]" required placeholder="Contoh: 500mg"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Frekuensi</label>
                                        <input type="text" name="items[0][frekuensi]" required placeholder="Contoh: 3x sehari"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi</label>
                                        <input type="text" name="items[0][durasi]" required placeholder="Contoh: 7 hari"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Instruksi</label>
                                        <textarea name="items[0][instruksi]" rows="2"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                            placeholder="Contoh: Diminum sesudah makan"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="addMedication()" class="mt-4 text-indigo-600 hover:text-indigo-700 font-semibold">
                            + Tambah Obat
                        </button>
                        @error('items')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                            Catatan
                        </label>
                        <textarea name="catatan" id="notes" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Catatan tambahan untuk resep ini">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('prescriptions.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Buat Resep
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let medicationIndex = 1;
// Parse medications data from server
const medicationsData = JSON.parse('{{ json_encode($medications) }}');

function addMedication() {
    const container = document.getElementById('medicationsContainer');
    const newMedication = `
        <div class="medication-item border border-gray-200 rounded-lg p-4">
            <div class="flex justify-between items-start mb-3">
                <h3 class="font-semibold text-gray-800">Obat #${medicationIndex + 1}</h3>
                <button type="button" onclick="this.closest('.medication-item').remove()"
                    class="text-red-600 hover:text-red-700 text-sm font-semibold">
                    Hapus
                </button>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Obat</label>
                    <select name="items[${medicationIndex}][obat_id]" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- Pilih Obat --</option>
                        ${medicationsData.map(med => `
                            <option value="${med.id}" data-price="${med.harga}">
                                ${med.nama} - Rp ${new Intl.NumberFormat('id-ID').format(med.harga)} (Stok: ${med.stok})
                            </option>
                        `).join('')}
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah</label>
                    <input type="number" name="items[${medicationIndex}][jumlah]" min="1" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Dosis</label>
                    <input type="text" name="items[${medicationIndex}][dosis]" required placeholder="Contoh: 500mg"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Frekuensi</label>
                    <input type="text" name="items[${medicationIndex}][frekuensi]" required placeholder="Contoh: 3x sehari"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi</label>
                    <input type="text" name="items[${medicationIndex}][durasi]" required placeholder="Contoh: 7 hari"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Instruksi</label>
                    <textarea name="items[${medicationIndex}][instruksi]" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        placeholder="Contoh: Diminum sesudah makan"></textarea>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newMedication);
    medicationIndex++;
}
</script>
@endsection
