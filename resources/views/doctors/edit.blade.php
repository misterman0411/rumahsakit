@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Dokter</h1>
            <p class="text-gray-600 mt-2">Update informasi dokter</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('doctors.update', $doctor) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <!-- User Account Section -->
                    <div class="bg-indigo-50 p-4 rounded-lg">
                        <h3 class="font-bold text-indigo-900 mb-4">Informasi Akun User</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama" id="name" required value="{{ old('nama', $doctor->user->nama) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('nama')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" required value="{{ old('email', $doctor->user->email) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password Baru (Kosongkan jika tidak ingin mengubah)
                                </label>
                                <input type="password" name="password" id="password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter jika diisi</p>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Doctor Information Section -->
                    <div>
                        <h3 class="font-bold text-gray-900 mb-4">Informasi Dokter</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="department_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Departemen <span class="text-red-500">*</span>
                                </label>
                                <select name="departemen_id" id="department_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">-- Pilih Departemen --</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('departemen_id', $doctor->departemen_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="specialization" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Spesialisasi <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="spesialisasi" id="specialization" required 
                                    value="{{ old('specialization', $doctor->spesialisasi) }}"
                                    placeholder="Contoh: Spesialis Penyakit Dalam"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('spesialisasi')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="license_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nomor Lisensi (STR) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nomor_lisensi" id="license_number" required 
                                    value="{{ old('license_number', $doctor->nomor_lisensi) }}"
                                    placeholder="Nomor STR"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('nomor_lisensi')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nomor Telepon <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="telepon" id="phone" required value="{{ old('telepon', $doctor->telepon) }}"
                                    placeholder="08xxxxxxxxxx"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                @error('telepon')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="consultation_fee" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Biaya Konsultasi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute left-4 top-2 text-gray-500">Rp</span>
                                    <input type="number" name="consultation_fee" id="consultation_fee" required 
                                        value="{{ old('consultation_fee', $doctor->consultation_fee) }}" min="0" step="1000"
                                        class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                @error('consultation_fee')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('doctors.index') }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Update Dokter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
