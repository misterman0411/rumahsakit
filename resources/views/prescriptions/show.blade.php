@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Resep</h1>
                <p class="text-gray-600 mt-2">{{ $prescription->nomor_resep }}</p>
            </div>
            <div class="flex space-x-2">
                @if(auth()->user()->hasRole('pharmacist'))
                    @if($prescription->status === 'menunggu')
                        <form action="{{ route('prescriptions.verify', $prescription) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                                ✓ Verifikasi
                            </button>
                        </form>
                        <button type="button" onclick="document.getElementById('rejectModal').classList.remove('hidden')" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                            ✗ Tolak
                        </button>
                    @endif
                    @if($prescription->status === 'diverifikasi')
                        <form action="{{ route('prescriptions.dispense', $prescription) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold">
                                📦 Serahkan Obat
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Prescription Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Resep</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nomor Resep</p>
                            <p class="font-semibold">{{ $prescription->nomor_resep }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                @if($prescription->status === 'diserahkan') bg-green-100 text-green-800
                                @elseif($prescription->status === 'diverifikasi') bg-blue-100 text-blue-800
                                @elseif($prescription->status === 'ditolak') bg-red-100 text-red-800
                                @elseif($prescription->status === 'dibatalkan') bg-gray-100 text-gray-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($prescription->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Dibuat</p>
                            <p class="font-semibold">{{ $prescription->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($prescription->waktu_verifikasi)
                        <div>
                            <p class="text-sm text-gray-500">Diverifikasi</p>
                            <p class="font-semibold">{{ $prescription->waktu_verifikasi->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                        @if($prescription->waktu_diserahkan)
                        <div>
                            <p class="text-sm text-gray-500">Diserahkan</p>
                            <p class="font-semibold">{{ $prescription->waktu_diserahkan->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                        @if($prescription->waktu_penolakan)
                        <div>
                            <p class="text-sm text-gray-500">Ditolak</p>
                            <p class="font-semibold">{{ $prescription->waktu_penolakan->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                    @if($prescription->alasan_penolakan)
                    <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-sm font-semibold text-red-800 mb-2">Alasan Penolakan:</p>
                        <p class="text-sm text-red-700">{{ $prescription->alasan_penolakan }}</p>
                    </div>
                    @endif
                    @if($prescription->catatan)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Catatan</p>
                        <p class="text-gray-800 mt-1">{{ $prescription->catatan }}</p>
                    </div>
                    @endif
                </div>

                <!-- Medications -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Obat</h2>
                    <div class="space-y-4">
                        @foreach($prescription->itemResep as $item)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg">{{ $item->obat->nama }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item->obat->kode }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Harga</p>
                                    <p class="font-bold text-indigo-600">Rp {{ number_format($item->obat->harga * $item->jumlah, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-3">
                                <div>
                                    <p class="text-xs text-gray-500">Jumlah</p>
                                    <p class="font-semibold">{{ $item->jumlah }} {{ $item->obat->satuan }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Dosis</p>
                                    <p class="font-semibold">{{ $item->dosis }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Frekuensi</p>
                                    <p class="font-semibold">{{ $item->frekuensi }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Durasi</p>
                                    <p class="font-semibold">{{ $item->durasi }}</p>
                                </div>
                            </div>
                            @if($item->instruksi)
                            <div class="mt-3 bg-blue-50 p-3 rounded-lg">
                                <p class="text-sm text-blue-800"><span class="font-semibold">Instruksi:</span> {{ $item->instruksi }}</p>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="mt-6 pt-4 border-t border-gray-200">
                        <div class="flex justify-between items-center">
                            <p class="text-lg font-bold text-gray-800">Total</p>
                            <p class="text-2xl font-bold text-indigo-600">
                                Rp {{ number_format($prescription->itemResep->sum(function($item) { return $item->obat->harga * $item->jumlah; }), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Patient Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Pasien</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">No. RM</p>
                            <p class="font-semibold">{{ $prescription->pasien->no_rekam_medis }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold">{{ $prescription->pasien->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jenis Kelamin</p>
                            <p>{{ $prescription->pasien->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Lahir</p>
                            <p>{{ \Carbon\Carbon::parse($prescription->pasien->tanggal_lahir)->format('d/m/Y') }}</p>
                        </div>
                        @if($prescription->pasien->alergi)
                        <div class="mt-3 bg-red-50 p-3 rounded-lg">
                            <p class="text-xs text-red-600 font-semibold mb-1">ALERGI:</p>
                            <p class="text-sm text-red-800">{{ $prescription->pasien->alergi }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Doctor Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Dokter Penanggung Jawab</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold">{{ $prescription->dokter->user->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Spesialisasi</p>
                            <p>{{ $prescription->dokter->spesialisasi }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">No. Lisensi</p>
                            <p>{{ $prescription->dokter->nomor_lisensi }}</p>
                        </div>
                    </div>
                </div>

                <!-- Invoice -->
                @if($prescription->tagihan)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Tagihan</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">No. Invoice</p>
                            <p class="font-semibold">{{ $prescription->tagihan->nomor_tagihan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total</p>
                            <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($prescription->tagihan->total, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                @if($prescription->tagihan->status === 'lunas') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($prescription->tagihan->status) }}
                            </span>
                        </div>
                        <a href="{{ route('billing.show', $prescription->tagihan) }}"
                            class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            Lihat Detail Tagihan
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full">
        <div class="p-6 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900">Tolak Resep</h3>
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <form method="POST" action="{{ route('prescriptions.reject', $prescription) }}" class="p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Alasan Penolakan <span class="text-red-500">*</span>
                </label>
                <textarea name="alasan_penolakan" rows="4" required 
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                    placeholder="Jelaskan alasan penolakan resep ini (minimal 10 karakter)...">{{ old('alasan_penolakan') }}</textarea>
                @error('alasan_penolakan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-500 mt-1">Pastikan alasan jelas dan dapat dipahami oleh dokter</p>
            </div>

            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" 
                    class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors font-semibold">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all font-semibold">
                    Tolak Resep
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
