@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Obat</h1>
            <p class="text-gray-600 mt-2">Update informasi obat</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('medications.update', $medication) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Obat -->
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Obat <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" required value="{{ old('nama', $medication->nama) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('nama')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kode Obat (Readonly) -->
                        <div>
                            <label for="kode" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kode Obat
                            </label>
                            <input type="text" id="kode" readonly value="{{ $medication->kode }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                        </div>

                        <!-- Bentuk Sediaan -->
                        <div>
                            <label for="bentuk_sediaan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Bentuk Sediaan <span class="text-red-500">*</span>
                            </label>
                            <select name="bentuk_sediaan" id="bentuk_sediaan" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Pilih Bentuk Sediaan --</option>
                                <option value="Tablet" {{ old('bentuk_sediaan', $medication->bentuk_sediaan) == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                                <option value="Kapsul" {{ old('bentuk_sediaan', $medication->bentuk_sediaan) == 'Kapsul' ? 'selected' : '' }}>Kapsul</option>
                                <option value="Sirup" {{ old('bentuk_sediaan', $medication->bentuk_sediaan) == 'Sirup' ? 'selected' : '' }}>Sirup</option>
                                <option value="Injeksi" {{ old('bentuk_sediaan', $medication->bentuk_sediaan) == 'Injeksi' ? 'selected' : '' }}>Injeksi</option>
                                <option value="Salep" {{ old('bentuk_sediaan', $medication->bentuk_sediaan) == 'Salep' ? 'selected' : '' }}>Salep</option>
                                <option value="Tetes" {{ old('bentuk_sediaan', $medication->bentuk_sediaan) == 'Tetes' ? 'selected' : '' }}>Tetes</option>
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
                            <input type="text" name="kekuatan" id="kekuatan" required value="{{ old('kekuatan', $medication->kekuatan) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('kekuatan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Satuan -->
                        <div>
                            <label for="satuan" class="block text-sm font-semibold text-gray-700 mb-2">
                                Satuan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="satuan" id="satuan" required value="{{ old('satuan', $medication->satuan) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('satuan')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div>
                            <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">
                                Harga (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="harga" id="harga" required value="{{ old('harga', $medication->harga) }}"
                                min="0" max="99999999"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
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
                            <input type="number" name="stok" id="stok" required value="{{ old('stok', $medication->stok) }}"
                                min="0" max="2147483647"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('stok')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stok Minimum -->
                        <div>
                            <label for="stok_minimum" class="block text-sm font-semibold text-gray-700 mb-2">
                                Stok Minimum <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stok_minimum" id="stok_minimum" required value="{{ old('stok_minimum', $medication->stok_minimum) }}"
                                min="0" max="2147483647"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('stok_minimum')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label for="kategori" class="block text-sm font-semibold text-gray-700 mb-2">
                                Kategori
                            </label>
                            <input type="text" name="kategori" id="kategori" value="{{ old('kategori', $medication->kategori) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('kategori')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Kadaluarsa -->
                        <div>
                            <label for="tanggal_kadaluarsa" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tanggal Kadaluarsa
                            </label>
                            <input type="date" name="tanggal_kadaluarsa" id="tanggal_kadaluarsa" 
                                value="{{ old('tanggal_kadaluarsa', $medication->tanggal_kadaluarsa?->format('Y-m-d')) }}"
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
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('deskripsi', $medication->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('medications.show', $medication) }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Update Obat
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
