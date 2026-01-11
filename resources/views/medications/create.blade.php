@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Tambah Obat Baru</h1>
            <p class="text-gray-600 mt-2">Tambahkan obat ke inventaris farmasi</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('medications.store') }}" method="POST">
                @csrf

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Obat -->
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Obat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" required value="{{ old('nama') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="Contoh: Paracetamol">
                            @error('nama')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kode Obat -->
                        <div>
                            <label for="kode" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kode Obat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kode" id="kode" required value="{{ old('kode') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="Contoh: PCT-500">
                            @error('kode')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bentuk Sediaan -->
                        <div>
                            <label for="bentuk_sediaan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Bentuk Sediaan <span class="text-red-500">*</span>
                            </label>
                            <select name="bentuk_sediaan" id="bentuk_sediaan" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Pilih Bentuk Sediaan --</option>
                                <option value="Tablet" {{ old('bentuk_sediaan') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                                <option value="Kapsul" {{ old('bentuk_sediaan') == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                                <option value="Sirup" {{ old('bentuk_sediaan') == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                                <option value="Injeksi" {{ old('bentuk_sediaan') == 'Injeksi' ? 'selected' : '' }}>Injeksi</option>
                                <option value="Salep" {{ old('bentuk_sediaan') == 'Salep' ? 'selected' : '' }}>Salep</option>
                                <option value="Tetes" {{ old('bentuk_sediaan') == 'Tetes' ? 'selected' : '' }}>Tetes</option>
                            </select>
                            @error('bentuk_sediaan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kekuatan -->
                        <div>
                            <label for="kekuatan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kekuatan/Dosis <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kekuatan" id="kekuatan" required value="{{ old('kekuatan') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="Contoh: 500mg">
                            @error('kekuatan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Satuan -->
                        <div>
                            <label for="satuan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Satuan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="satuan" id="satuan" required value="{{ old('satuan', 'tablet') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="Contoh: tablet, botol, strip">
                            @error('satuan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div>
                            <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">
                                Harga (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="harga" id="harga" required value="{{ old('harga') }}"
                                min="0" max="99999999"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="0.00">
                            <p class="text-xs text-gray-500 mt-1">Maksimal: Rp 99,999,999.99</p>
                            @error('harga')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">
                                Stok <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stok" id="stok" required value="{{ old('stok', 0) }}"
                                min="0" max="2147483647"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="0">
                            @error('stok')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stok Minimum -->
                        <div>
                            <label for="stok_minimum" class="block text-sm font-semibold text-gray-700 mb-2">
                                Stok Minimum <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stok_minimum" id="stok_minimum" required value="{{ old('stok_minimum', 10) }}"                                min="0" max="2147483647"                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="10">
                            @error('stok_minimum')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kategori
                            </label>
                            <input type="text" name="kategori" id="kategori" value="{{ old('kategori') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                                placeholder="Contoh: Analgesik, Antibiotik">
                            @error('kategori')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Kadaluarsa -->
                        <div>
                            <label for="tanggal_kadaluarsa" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tanggal Kadaluarsa
                            </label>
                            <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('tanggal_kadaluarsa')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                            placeholder="Medication description, indications, contraindications">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                            placeholder="Deskripsi obat, indikasi, kontraindikasi">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('medications.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Simpan Obat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
