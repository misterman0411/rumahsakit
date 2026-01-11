@extends('layouts.app')

@section('title', 'Detail Rawat Inap')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('inpatient.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-4 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Detail Rawat Inap</h2>
                <p class="text-gray-500 mt-1">{{ $inpatient->admission_number }}</p>
            </div>
            @if($inpatient->status === 'dirawat')
            <button type="button" onclick="document.getElementById('dischargeModal').classList.remove('hidden')" class="px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-xl shadow-lg hover:shadow-xl transition-all font-semibold">
                Pulangkan Pasien
            </button>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Patient Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 via-purple-50 to-white border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Informasi Pasien</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-semibold text-gray-500 mb-1">Nama Pasien</dt>
                            <dd class="text-base font-bold text-gray-900">{{ $inpatient->pasien->nama }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-semibold text-gray-500 mb-1">No. Rekam Medis</dt>
                            <dd class="text-base font-bold text-gray-900">{{ $inpatient->pasien->no_rekam_medis }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-semibold text-gray-500 mb-1">Tanggal Lahir</dt>
                            <dd class="text-base text-gray-900">{{ \Carbon\Carbon::parse($inpatient->pasien->tanggal_lahir)->format('d M Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-semibold text-gray-500 mb-1">Jenis Kelamin</dt>
                            <dd class="text-base text-gray-900">{{ $inpatient->pasien->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Admission Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-indigo-50 via-purple-50 to-white border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Detail Rawat Inap</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-semibold text-gray-500 mb-1">Dokter Penanggung Jawab</dt>
                            <dd class="text-base font-bold text-gray-900">{{ $inpatient->dokter->user->nama }}</dd>
                            <dd class="text-sm text-gray-600">{{ $inpatient->dokter->spesialisasi }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-semibold text-gray-500 mb-1">Kamar / Tempat Tidur</dt>
                            <dd class="text-base font-bold text-gray-900">{{ $inpatient->ruangan->nomor_ruangan }} / Bed {{ $inpatient->tempatTidur->nomor_tempat_tidur }}</dd>
                            <dd class="text-sm text-gray-600">{{ ucfirst($inpatient->ruangan->ruangan_type) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-semibold text-gray-500 mb-1">Tanggal Masuk</dt>
                            <dd class="text-base text-gray-900">{{ \Carbon\Carbon::parse($inpatient->tanggal_masuk)->format('d M Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-semibold text-gray-500 mb-1">Tipe Rawat Inap</dt>
                            <dd class="text-base text-gray-900">{{ ucfirst($inpatient->admission_type) }}</dd>
                        </div>
                        <div class="col-span-2">
                            <dt class="text-sm font-semibold text-gray-500 mb-1">Alasan Rawat Inap</dt>
                            <dd class="text-base text-gray-900">{{ $inpatient->reason }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Discharge Info (if discharged) -->
            @if($inpatient->status === 'pulang')
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-white border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Informasi Kepulangan</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-semibold text-gray-500 mb-1">Tanggal Pulang</dt>
                            <dd class="text-base text-gray-900">{{ \Carbon\Carbon::parse($inpatient->tanggal_keluar)->format('d M Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-semibold text-gray-500 mb-1">Status Pulang</dt>
                            <dd class="text-base text-gray-900">{{ ucfirst(str_replace('_', ' ', $inpatient->discharge_status)) }}</dd>
                        </div>
                        @if($inpatient->follow_up_date)
                        <div>
                            <dt class="text-sm font-semibold text-gray-500 mb-1">Tanggal Follow Up</dt>
                            <dd class="text-base text-gray-900">{{ \Carbon\Carbon::parse($inpatient->follow_up_date)->format('d M Y') }}</dd>
                        </div>
                        @endif
                        <div class="col-span-2">
                            <dt class="text-sm font-semibold text-gray-500 mb-1">Ringkasan Kepulangan</dt>
                            <dd class="text-base text-gray-900">{{ $inpatient->ringkasan_keluar }}</dd>
                        </div>
                        @if($inpatient->discharge_instructions)
                        <div class="col-span-2">
                            <dt class="text-sm font-semibold text-gray-500 mb-1">Instruksi Kepulangan</dt>
                            <dd class="text-base text-gray-900">{{ $inpatient->discharge_instructions }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-bold text-gray-500 uppercase mb-3">Status</h3>
                @if($inpatient->status === 'admitted')
                    <span class="inline-block px-4 py-2 text-sm font-bold rounded-full bg-blue-100 text-blue-800">Dirawat</span>
                @else
                    <span class="inline-block px-4 py-2 text-sm font-bold rounded-full bg-green-100 text-green-800">Pulang</span>
                @endif
            </div>

            <!-- Duration Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-bold text-gray-500 uppercase mb-3">Lama Rawat Inap</h3>
                <p class="text-3xl font-bold text-indigo-600">
                    @if($inpatient->tanggal_keluar)
                        {{ \Carbon\Carbon::parse($inpatient->tanggal_masuk)->diffInDays(\Carbon\Carbon::parse($inpatient->tanggal_keluar)) }}
                    @else
                        {{ \Carbon\Carbon::parse($inpatient->tanggal_masuk)->diffInDays(now()) }}
                    @endif
                    <span class="text-lg text-gray-600">hari</span>
                </p>
            </div>

            <!-- Invoice Card -->
            @if($inpatient->tagihan)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-bold text-gray-500 uppercase mb-3">Invoice</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Total Tagihan</span>
                        <span class="text-sm font-bold text-gray-900">Rp {{ number_format($inpatient->tagihan->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="text-sm font-semibold {{ $inpatient->tagihan->status === 'lunas' ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ ucfirst($inpatient->tagihan->status) }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('billing.show', $inpatient->tagihan) }}" class="mt-4 block text-center px-4 py-2 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg transition-colors font-semibold text-sm">
                    Lihat Invoice
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Discharge Modal -->
<div id="dischargeModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900">Pulangkan Pasien</h3>
                <button type="button" onclick="document.getElementById('dischargeModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <form method="POST" action="{{ route('inpatient.discharge', $inpatient) }}" class="p-6">
            @csrf
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pulang <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="tanggal_keluar" value="{{ old('tanggal_keluar', now()->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('tanggal_keluar')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Status Pulang <span class="text-red-500">*</span></label>
                        <select name="status_pulang" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="sembuh" {{ old('status_pulang') == 'sembuh' ? 'selected' : '' }}>Sembuh</option>
                            <option value="dirujuk" {{ old('status_pulang') == 'dirujuk' ? 'selected' : '' }}>Dirujuk</option>
                            <option value="meninggal" {{ old('status_pulang') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                            <option value="aps" {{ old('status_pulang') == 'aps' ? 'selected' : '' }}>Pulang Paksa (APS)</option>
                        </select>
                        @error('status_pulang')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Ringkasan Kepulangan (Resume Keluar) <span class="text-red-500">*</span></label>
                    <textarea name="resume_keluar" rows="4" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Diagnosis akhir, tindakan yang dilakukan, kondisi pasien saat pulang...">{{ old('resume_keluar') }}</textarea>
                    @error('resume_keluar')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Instruksi Kepulangan</label>
                    <textarea name="instruksi_pulang" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Obat yang harus diminum, pantangan, jadwal kontrol...">{{ old('instruksi_pulang') }}</textarea>
                    @error('instruksi_pulang')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kontrol</label>
                    <input type="date" name="tanggal_kontrol" value="{{ old('tanggal_kontrol') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Diskon (Rp)</label>
                        <input type="number" name="diskon" value="0" min="0" step="0.01" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Pajak (Rp)</label>
                        <input type="number" name="pajak" value="0" min="0" step="0.01" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <button type="button" onclick="document.getElementById('dischargeModal').classList.add('hidden')" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors font-semibold">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg shadow-md hover:shadow-lg transition-all font-semibold">
                    Pulangkan Pasien
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
