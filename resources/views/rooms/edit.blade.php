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
                        <!-- Type -->
                        <div>
                            <label for="room_type" class="block text-sm font-semibold text-gray-700 mb-2">
                                Room Type <span class="text-red-500">*</span>
                            </label>
                            <select name="tipe_ruangan" id="tipe_ruangan" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="vip" {{ old('tipe_ruangan', $room->tipe_ruangan) == 'vip' ? 'selected' : '' }}>VIP</option>
                                <option value="kelas_1" {{ old('tipe_ruangan', $room->tipe_ruangan) == 'kelas_1' ? 'selected' : '' }}>Kelas 1</option>
                                <option value="kelas_2" {{ old('tipe_ruangan', $room->tipe_ruangan) == 'kelas_2' ? 'selected' : '' }}>Kelas 2</option>
                                <option value="kelas_3" {{ old('tipe_ruangan', $room->tipe_ruangan) == 'kelas_3' ? 'selected' : '' }}>Kelas 3</option>
                                <option value="icu" {{ old('tipe_ruangan', $room->tipe_ruangan) == 'icu' ? 'selected' : '' }}>ICU</option>
                                <option value="darurat" {{ old('tipe_ruangan', $room->tipe_ruangan) == 'darurat' ? 'selected' : '' }}>Darurat</option>
                            </select>
                            @error('room_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Floor -->
                        <div>
                            <label for="floor" class="block text-sm font-semibold text-gray-700 mb-2">
                                Floor <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="floor" id="floor" required value="{{ old('floor', $room->floor) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('floor')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Daily Rate -->
                        <div>
                            <label for="daily_rate" class="block text-sm font-semibold text-gray-700 mb-2">
                                Daily Rate (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="daily_rate" id="daily_rate" required value="{{ old('daily_rate', $room->daily_rate) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('daily_rate')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                                Status
                            </label>
                            <select name="status" id="status"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="tersedia" {{ old('status', $room->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="terisi" {{ old('status', $room->status) == 'terisi' ? 'selected' : '' }}>Terisi</option>
                                <option value="perawatan" {{ old('status', $room->status) == 'perawatan' ? 'selected' : '' }}>Dalam Perawatan</option>
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
                        <p class="text-sm text-gray-500 mt-1">Capacity cannot be changed. Current beds: {{ $room->tempatTidurs->count() }}</p>
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
