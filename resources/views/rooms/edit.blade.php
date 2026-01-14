@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Room</h1>
            <p class="text-gray-600 mt-2">Update room information - {{ $room->nomor_ruangan }}</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('rooms.update', $room) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <!-- Room Number (Read-only) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Room Number
                        </label>
                        <input type="text" value="{{ $room->nomor_ruangan }}" readonly
                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Room Name -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Ruangan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" id="name" required value="{{ old('nama', $room->nama) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('nama')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="departemen_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Departemen <span class="text-red-500">*</span>
                            </label>
                            <select name="departemen_id" id="departemen_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="">-- Pilih Departemen --</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('departemen_id', $room->departemen_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('departemen_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="jenis" class="block text-sm font-semibold text-gray-700 mb-2">
                                Jenis Ruangan <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis" id="jenis" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="vip" {{ old('jenis', $room->jenis) == 'vip' ? 'selected' : '' }}>VIP</option>
                                <option value="kelas_1" {{ old('jenis', $room->jenis) == 'kelas_1' ? 'selected' : '' }}>Kelas 1</option>
                                <option value="kelas_2" {{ old('jenis', $room->jenis) == 'kelas_2' ? 'selected' : '' }}>Kelas 2</option>
                                <option value="kelas_3" {{ old('jenis', $room->jenis) == 'kelas_3' ? 'selected' : '' }}>Kelas 3</option>
                                <option value="icu" {{ old('jenis', $room->jenis) == 'icu' ? 'selected' : '' }}>ICU</option>
                                <option value="isolasi" {{ old('jenis', $room->jenis) == 'isolasi' ? 'selected' : '' }}>Isolasi</option>
                            </select>
                            @error('jenis')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Daily Rate -->
                        <div>
                            <label for="tarif_per_hari" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tarif Per Hari (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="tarif_per_hari" id="tarif_per_hari" required value="{{ old('tarif_per_hari', $room->tarif_per_hari) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('tarif_per_hari')
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
                                <option value="tersedia" {{ old('status', $room->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="terisi" {{ old('status', $room->status) == 'terisi' ? 'selected' : '' }}>Terisi</option>
                                <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Capacity (Read-only) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Capacity (Beds)
                        </label>
                        <input type="text" value="{{ $room->kapasitas }} beds" readonly
                            class="w-full px-4 py-2 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                        <p class="text-sm text-gray-500 mt-1">Capacity cannot be changed. Current beds: {{ $room->tempatTidur->count() }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('rooms.show', $room) }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Update Room
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
