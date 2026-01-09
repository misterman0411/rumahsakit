@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Record Stock Movement</h1>
            <p class="text-gray-600 mt-2">Catat pergerakan stok obat (masuk/penyesuaian)</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
            <form method="POST" action="{{ route('stock-movements.store') }}">
                @csrf

                <!-- Medication -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Obat <span class="text-red-500">*</span>
                    </label>
                    <select name="obat_id" required 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('obat_id') border-red-500 @enderror">
                        <option value="">Pilih Obat</option>
                        @foreach($medications as $medication)
                        <option value="{{ $medication->id }}" {{ old('obat_id') == $medication->id ? 'selected' : '' }}>
                            {{ $medication->nama }} - {{ $medication->kekuatan }} (Stok: {{ $medication->stok }} {{ $medication->satuan }})
                        </option>
                        @endforeach
                    </select>
                    @error('obat_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Mutasi -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jenis Mutasi <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_mutasi" required 
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('jenis_mutasi') border-red-500 @enderror">
                        <option value="">Pilih Jenis</option>
                        <option value="masuk" {{ old('jenis_mutasi') == 'masuk' ? 'selected' : '' }}>Masuk (Pembelian/Penerimaan)</option>
                        <option value="penyesuaian" {{ old('jenis_mutasi') == 'penyesuaian' ? 'selected' : '' }}>Penyesuaian (Stock Opname)</option>
                    </select>
                    @error('jenis_mutasi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        <strong>Catatan:</strong> Untuk pengeluaran obat, gunakan menu Pharmacy → Dispense
                    </p>
                </div>

                <!-- Jumlah -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="jumlah" value="{{ old('jumlah') }}" required min="1" step="1"
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('jumlah') border-red-500 @enderror"
                           placeholder="Masukkan jumlah">
                    @error('jumlah')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keterangan -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Keterangan
                    </label>
                    <textarea name="keterangan" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 @error('keterangan') border-red-500 @enderror"
                              placeholder="Catatan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3">
                            <p class="text-sm text-blue-800 font-semibold">Informasi Penting</p>
                            <ul class="text-sm text-blue-700 mt-2 space-y-1">
                                <li>• <strong>Masuk:</strong> Untuk penerimaan obat baru dari supplier</li>
                                <li>• <strong>Penyesuaian:</strong> Untuk koreksi stok berdasarkan stock opname</li>
                                <li>• <strong>Keluar:</strong> Otomatis tercatat saat dispense prescription</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('stock-movements.index') }}" 
                       class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors font-semibold">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:shadow-lg text-white rounded-lg transition-all font-semibold">
                        Simpan Movement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
