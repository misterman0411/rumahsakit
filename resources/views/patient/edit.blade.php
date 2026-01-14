@extends('layouts.app')

@section('title', 'Edit Patient')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Patient: {{ $patient->nama }}</h2>
    </div>

    <form action="{{ route('patients.update', $patient) }}" method="POST" class="p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- MRN (Read Only) -->
            <div>
                <label class="block text-sm font-medium text-gray-700">MRN</label>
                <input type="text" value="{{ $patient->no_rekam_medis }}" disabled
                    class="mt-1 block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md">
            </div>

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                <input type="text" name="nama" id="name" required value="{{ old('nama', $patient->nama) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('nama') border-red-500 @enderror">
                @error('nama')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date of Birth -->
            <div>
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth *</label>
                <input type="date" name="tanggal_lahir" id="date_of_birth" required value="{{ old('tanggal_lahir', $patient->tanggal_lahir->format('Y-m-d')) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Gender -->
            <div>
                <label for="gender" class="block text-sm font-medium text-gray-700">Gender *</label>
                <select name="jenis_kelamin" id="gender" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="laki_laki" {{ old('jenis_kelamin', $patient->jenis_kelamin) == 'laki_laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="perempuan" {{ old('jenis_kelamin', $patient->jenis_kelamin) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <!-- Phone -->
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone *</label>
                <input type="text" name="telepon" id="phone" required value="{{ old('telepon', $patient->telepon) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $patient->email) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- NIK -->
            <div>
                <label for="nik" class="block text-sm font-medium text-gray-700">NIK (Nomor Induk Kependudukan)</label>
                <input type="text" name="nik" id="nik" maxlength="16" value="{{ old('nik', $patient->nik) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="16 digit NIK">
                @error('nik')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Religion -->
            <div>
                <label for="religion" class="block text-sm font-medium text-gray-700">Agama</label>
                <select name="agama" id="religion"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Agama</option>
                    <option value="islam" {{ old('agama', $patient->agama) == 'islam' ? 'selected' : '' }}>Islam</option>
                    <option value="kristen" {{ old('agama', $patient->agama) == 'kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="katolik" {{ old('agama', $patient->agama) == 'katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="hindu" {{ old('agama', $patient->agama) == 'hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="buddha" {{ old('agama', $patient->agama) == 'buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="konghucu" {{ old('agama', $patient->agama) == 'konghucu' ? 'selected' : '' }}>Konghucu</option>
                    <option value="other" {{ old('agama', $patient->agama) == 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <!-- Marital Status -->
            <div>
                <label for="marital_status" class="block text-sm font-medium text-gray-700">Status Pernikahan</label>
                <select name="status_pernikahan" id="marital_status"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Status</option>
                    <option value="belum_menikah" {{ old('status_pernikahan', $patient->status_pernikahan) == 'belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                    <option value="menikah" {{ old('status_pernikahan', $patient->status_pernikahan) == 'menikah' ? 'selected' : '' }}>Menikah</option>
                    <option value="cerai" {{ old('status_pernikahan', $patient->status_pernikahan) == 'cerai' ? 'selected' : '' }}>Cerai</option>
                    <option value="janda_duda" {{ old('status_pernikahan', $patient->status_pernikahan) == 'janda_duda' ? 'selected' : '' }}>Duda/Janda</option>
                </select>
            </div>

            <!-- Nationality -->
            <div>
                <label for="nationality" class="block text-sm font-medium text-gray-700">Kewarganegaraan</label>
                <input type="text" name="kewarganegaraan" id="nationality" value="{{ old('kewarganegaraan', $patient->kewarganegaraan) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Occupation -->
            <div>
                <label for="occupation" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                <input type="text" name="pekerjaan" id="occupation" value="{{ old('pekerjaan', $patient->pekerjaan) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Address -->
            <div class="md:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700">Address *</label>
                <textarea name="alamat" id="address" rows="3" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('alamat', $patient->alamat) }}</textarea>
            </div>

            <!-- Emergency Contact Name -->
            <div>
                <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">Emergency Contact Name</label>
                <input type="text" name="nama_kontak_darurat" id="emergency_contact_name" value="{{ old('nama_kontak_darurat', $patient->nama_kontak_darurat) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Emergency Contact Phone -->
            <div>
                <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">Emergency Contact Phone</label>
                <input type="text" name="telepon_kontak_darurat" id="emergency_contact_phone" value="{{ old('telepon_kontak_darurat', $patient->telepon_kontak_darurat) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Blood Type -->
            <div>
                <label for="blood_type" class="block text-sm font-medium text-gray-700">Blood Type</label>
                <select name="golongan_darah" id="blood_type"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Select Blood Type</option>
                    <option value="A+" {{ old('golongan_darah', $patient->golongan_darah) == 'A+' ? 'selected' : '' }}>A+</option>
                    <option value="A-" {{ old('golongan_darah', $patient->golongan_darah) == 'A-' ? 'selected' : '' }}>A-</option>
                    <option value="B+" {{ old('golongan_darah', $patient->golongan_darah) == 'B+' ? 'selected' : '' }}>B+</option>
                    <option value="B-" {{ old('golongan_darah', $patient->golongan_darah) == 'B-' ? 'selected' : '' }}>B-</option>
                    <option value="AB+" {{ old('golongan_darah', $patient->golongan_darah) == 'AB+' ? 'selected' : '' }}>AB+</option>
                    <option value="AB-" {{ old('golongan_darah', $patient->golongan_darah) == 'AB-' ? 'selected' : '' }}>AB-</option>
                    <option value="O+" {{ old('golongan_darah', $patient->golongan_darah) == 'O+' ? 'selected' : '' }}>O+</option>
                    <option value="O-" {{ old('golongan_darah', $patient->golongan_darah) == 'O-' ? 'selected' : '' }}>O-</option>
                </select>
            </div>

            <!-- Allergies -->
            <div class="md:col-span-2">
                <label for="allergies" class="block text-sm font-medium text-gray-700">Allergies</label>
                <textarea name="alergi" id="allergies" rows="2"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('alergi', $patient->alergi) }}</textarea>
            </div>

            <!-- Medical History -->
            <div class="md:col-span-2">
                <label for="medical_history" class="block text-sm font-medium text-gray-700">Riwayat Penyakit/Medical History</label>
                <textarea name="medical_history" id="medical_history" rows="3"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Riwayat penyakit yang pernah diderita, operasi, dll">{{ old('medical_history', $patient->medical_history) }}</textarea>
            </div>

            <!-- Insurance Type -->
            <div>
                <label for="insurance_type" class="block text-sm font-medium text-gray-700">Insurance Type</label>
                <select name="jenis_asuransi" id="insurance_type"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="tidak_ada" {{ old('jenis_asuransi', $patient->jenis_asuransi) == 'tidak_ada' ? 'selected' : '' }}>None</option>
                    <option value="bpjs" {{ old('jenis_asuransi', $patient->jenis_asuransi) == 'bpjs' ? 'selected' : '' }}>BPJS</option>
                    <option value="asuransi_swasta" {{ old('jenis_asuransi', $patient->jenis_asuransi) == 'asuransi_swasta' ? 'selected' : '' }}>Private Insurance</option>
                </select>
            </div>

            <!-- Insurance Number -->
            <div>
                <label for="insurance_number" class="block text-sm font-medium text-gray-700">Insurance Number</label>
                <input type="text" name="nomor_asuransi" id="insurance_number" value="{{ old('nomor_asuransi', $patient->nomor_asuransi) }}"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="aktif" {{ old('status', $patient->status) == 'aktif' ? 'selected' : '' }}>Active</option>
                    <option value="tidak_aktif" {{ old('status', $patient->status) == 'tidak_aktif' ? 'selected' : '' }}>Inactive</option>
                    <option value="meninggal" {{ old('status', $patient->status) == 'meninggal' ? 'selected' : '' }}>Deceased</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('patients.show', $patient) }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                Cancel
            </a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Update Patient
            </button>
        </div>
    </form>
</div>
@endsection
