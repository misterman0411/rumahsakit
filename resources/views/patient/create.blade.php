@extends('layouts.app')

@section('title', 'Add New Patient')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800">Add New Patient</h2>
    </div>

    <form action="{{ route('patients.store') }}" method="POST" class="p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                <input type="text" name="nama" id="name" required value="{{ old('nama') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nama') border-red-500 @enderror">
                @error('nama')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date of Birth -->
            <div>
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth *</label>
                <input type="date" name="tanggal_lahir" id="date_of_birth" required value="{{ old('tanggal_lahir') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tanggal_lahir') border-red-500 @enderror">
                @error('tanggal_lahir')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender *</label>
                <select name="jenis_kelamin" id="gender" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('jenis_kelamin') border-red-500 @enderror">
                    <option value="">Select Gender</option>
                    <option value="laki_laki" {{ old('jenis_kelamin') == 'laki_laki' ? 'selected' : '' }}>Male</option>
                    <option value="perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>Female</option>
                </select>
                @error('jenis_kelamin')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone *</label>
                <input type="text" name="telepon" id="phone" required value="{{ old('telepon') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('telepon') border-red-500 @enderror">
                @error('telepon')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- NIK -->
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK (Nomor Induk Kependudukan)</label>
                <input type="text" name="nik" id="nik" maxlength="16" value="{{ old('nik') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nik') border-red-500 @enderror"
                    placeholder="16 digit NIK">
                @error('nik')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tempat Lahir -->
            <div>
                <label for="tempat_lahir" class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" id="tempat_lahir" value="{{ old('tempat_lahir') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('tempat_lahir') border-red-500 @enderror">
                @error('tempat_lahir')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Religion -->
            <div>
                <label for="religion" class="block text-sm font-medium text-gray-700">Agama</label>
                <select name="agama" id="religion"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('agama') border-red-500 @enderror">
                    <option value="">Pilih Agama</option>
                    <option value="islam" {{ old('agama') == 'islam' ? 'selected' : '' }}>Islam</option>
                    <option value="kristen" {{ old('agama') == 'kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="katolik" {{ old('agama') == 'katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="hindu" {{ old('agama') == 'hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="buddha" {{ old('agama') == 'buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="konghucu" {{ old('agama') == 'konghucu' ? 'selected' : '' }}>Konghucu</option>
                    <option value="other" {{ old('agama') == 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('agama')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Marital Status -->
            <div>
                <label for="marital_status" class="block text-sm font-medium text-gray-700">Status Pernikahan</label>
                <select name="status_pernikahan" id="marital_status"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status_pernikahan') border-red-500 @enderror">
                    <option value="">Pilih Status</option>
                    <option value="belum_menikah" {{ old('status_pernikahan') == 'belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                    <option value="menikah" {{ old('status_pernikahan') == 'menikah' ? 'selected' : '' }}>Menikah</option>
                    <option value="cerai" {{ old('status_pernikahan') == 'cerai' ? 'selected' : '' }}>Cerai</option>
                    <option value="janda_duda" {{ old('status_pernikahan') == 'janda_duda' ? 'selected' : '' }}>Duda/Janda</option>
                </select>
                @error('status_pernikahan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nationality -->
            <div>
                <label for="nationality" class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                <input type="text" name="kewarganegaraan" id="nationality" value="{{ old('kewarganegaraan', 'Indonesia') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('kewarganegaraan') border-red-500 @enderror">
                @error('kewarganegaraan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Occupation -->
            <div>
                <label for="occupation" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                <input type="text" name="pekerjaan" id="occupation" value="{{ old('pekerjaan') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('pekerjaan') border-red-500 @enderror">
                @error('pekerjaan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Address -->
            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700">Address *</label>
                <textarea name="alamat" id="address" rows="3" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Emergency Contact Name -->
            <div>
                <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">Emergency Contact Name *</label>
                <input type="text" name="nama_kontak_darurat" id="emergency_contact_name" required value="{{ old('nama_kontak_darurat') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nama_kontak_darurat') border-red-500 @enderror">
                @error('nama_kontak_darurat')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Emergency Contact Phone -->
            <div>
                <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">Emergency Contact Phone *</label>
                <input type="text" name="telepon_kontak_darurat" id="emergency_contact_phone" required value="{{ old('telepon_kontak_darurat') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('telepon_kontak_darurat') border-red-500 @enderror">
                @error('telepon_kontak_darurat')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Blood Type -->
            <div>
                <label for="blood_type" class="block text-sm font-medium text-gray-700">Blood Type</label>
                <select name="golongan_darah" id="blood_type"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Blood Type</option>
                    <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                    <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                    <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                    <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                    <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                    <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                    <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                    <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                </select>
            </div>

            <!-- Allergies -->
            <div class="md:col-span-2">
                <label for="allergies" class="block text-sm font-medium text-gray-700">Allergies</label>
                <textarea name="alergi" id="allergies" rows="2"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('alergi') border-red-500 @enderror">{{ old('alergi') }}</textarea>
                @error('alergi')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Medical History -->
            <div class="md:col-span-2">
                <label for="medical_history" class="block text-sm font-medium text-gray-700">Riwayat Penyakit/Medical History</label>
                <textarea name="medical_history" id="medical_history" rows="3"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('medical_history') border-red-500 @enderror"
                    placeholder="Riwayat penyakit yang pernah diderita, operasi, dll">{{ old('medical_history') }}</textarea>
                @error('medical_history')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Insurance Type -->
            <div>
                <label for="insurance_type" class="block text-sm font-medium text-gray-700">Insurance Type</label>
                <select name="jenis_asuransi" id="insurance_type"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('jenis_asuransi') border-red-500 @enderror">
                    <option value="tidak_ada" {{ old('jenis_asuransi') == 'tidak_ada' ? 'selected' : '' }}>None</option>
                    <option value="bpjs" {{ old('jenis_asuransi') == 'bpjs' ? 'selected' : '' }}>BPJS</option>
                    <option value="asuransi_swasta" {{ old('jenis_asuransi') == 'asuransi_swasta' ? 'selected' : '' }}>Private Insurance</option>
                </select>
                @error('jenis_asuransi')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Insurance Number -->
            <div>
                <label for="insurance_number" class="block text-sm font-medium text-gray-700">Insurance Number</label>
                <input type="text" name="nomor_asuransi" id="insurance_number" value="{{ old('nomor_asuransi') }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nomor_asuransi') border-red-500 @enderror">
                @error('nomor_asuransi')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Active</option>
                    <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Inactive</option>
                    <option value="meninggal" {{ old('status') == 'meninggal' ? 'selected' : '' }}>Deceased</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('patients.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Save Patient
            </button>
        </div>
    </form>
</div>
@endsection
