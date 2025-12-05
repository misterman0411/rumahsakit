@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Tambah Ruangan Baru</h1>
            <p class="text-gray-600 mt-2">Tambahkan ruangan baru ke rumah sakit</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf

                <div class="p-6 space-y-6">
                    <!-- Room Number -->
                    <div>
                        <label for="nomor_ruangan" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nomor Ruangan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nomor_ruangan" id="nomor_ruangan" required value="{{ old('nomor_ruangan') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="e.g., 101, A-201">
                        @error('nomor_ruangan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type -->
                        <div>
                            <label for="jenis" class="block text-sm font-semibold text-gray-700 mb-2">
                                Jenis Ruangan <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis" id="jenis" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="vip" {{ old('jenis') == 'vip' ? 'selected' : '' }}>VIP</option>
                                <option value="kelas_1" {{ old('jenis') == 'kelas_1' ? 'selected' : '' }}>Kelas 1</option>
                                <option value="kelas_2" {{ old('jenis') == 'kelas_2' ? 'selected' : '' }}>Kelas 2</option>
                                <option value="kelas_3" {{ old('jenis') == 'kelas_3' ? 'selected' : '' }}>Kelas 3</option>
                                <option value="icu" {{ old('jenis') == 'icu' ? 'selected' : '' }}>ICU</option>
                                <option value="ugd" {{ old('jenis') == 'ugd' ? 'selected' : '' }}>UGD</option>
                            </select>
                            @error('jenis')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Floor -->
                        <div>
                            <label for="lantai" class="block text-sm font-semibold text-gray-700 mb-2">
                                Lantai <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="lantai" id="lantai" required value="{{ old('lantai') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="e.g., 1, 2, 3">
                            @error('floor')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Capacity -->
                        <div>
                            <label for="kapasitas" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kapasitas (Tempat Tidur) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="kapasitas" id="kapasitas" required value="{{ old('kapasitas', 1) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="1">
                            @error('capacity')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Daily Rate -->
                        <div>
                            <label for="tarif_per_hari" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tarif Per Hari (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="tarif_per_hari" id="tarif_per_hari" required value="{{ old('tarif_per_hari') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="0.00">
                            @error('daily_rate')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="md:col-span-2">
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                Status
                            </label>
                            <select name="status" id="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="tersedia" {{ old('status', 'tersedia') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="terisi" {{ old('status') == 'terisi' ? 'selected' : '' }}>Terisi</option>
                                <option value="pemeliharaan" {{ old('status') == 'pemeliharaan' ? 'selected' : '' }}>Dalam Pemeliharaan</option>
                                <option value="dipesan" {{ old('status') == 'dipesan' ? 'selected' : '' }}>Dipesan</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Facilities -->
                    <div>
                        <label for="fasilitas" class="block text-sm font-semibold text-gray-700 mb-2">
                            Fasilitas
                        </label>
                        <textarea name="fasilitas" id="fasilitas" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                            placeholder="Daftar fasilitas yang tersedia di ruangan ini (contoh: AC, TV, Kamar Mandi Pribadi)">{{ old('fasilitas') }}</textarea>
                        @error('fasilitas')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('rooms.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Simpan Ruangan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
