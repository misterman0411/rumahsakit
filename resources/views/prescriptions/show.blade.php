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
                @if($prescription->status === 'pending')
                    <form action="{{ route('prescriptions.verify', $prescription) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Verifikasi
                        </button>
                    </form>
                @endif
                @if($prescription->status === 'verified')
                    <form action="{{ route('prescriptions.dispense', $prescription) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Serahkan Obat
                        </button>
                    </form>
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
                                @if($prescription->status === 'dispensed') bg-green-100 text-green-800
                                @elseif($prescription->status === 'verified') bg-blue-100 text-blue-800
                                @elseif($prescription->status === 'cancelled') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($prescription->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Dibuat</p>
                            <p class="font-semibold">{{ $prescription->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($prescription->verified_at)
                        <div>
                            <p class="text-sm text-gray-500">Diverifikasi</p>
                            <p class="font-semibold">{{ $prescription->verified_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                        @if($prescription->dispensed_at)
                        <div>
                            <p class="text-sm text-gray-500">Diserahkan</p>
                            <p class="font-semibold">{{ $prescription->dispensed_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
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
                        @foreach($prescription->items as $item)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <h3 class="font-bold text-gray-800 text-lg">{{ $item->obat->nama }}</h3>
                                    <p class="text-sm text-gray-600">{{ $item->obat->generic_name }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Harga</p>
                                    <p class="font-bold text-indigo-600">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-3">
                                <div>
                                    <p class="text-xs text-gray-500">Jumlah</p>
                                    <p class="font-semibold">{{ $item->jumlah }} {{ $item->obat->unit }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Dosis</p>
                                    <p class="font-semibold">{{ $item->dosage }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Frekuensi</p>
                                    <p class="font-semibold">{{ $item->frequency }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Durasi</p>
                                    <p class="font-semibold">{{ $item->duration }}</p>
                                </div>
                            </div>
                            @if($item->instructions)
                            <div class="mt-3 bg-blue-50 p-3 rounded-lg">
                                <p class="text-sm text-blue-800"><span class="font-semibold">Instruksi:</span> {{ $item->instructions }}</p>
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
                                Rp {{ number_format($prescription->items->sum('price'), 0, ',', '.') }}
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
                            <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($prescription->tagihan->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                @if($prescription->tagihan->status === 'paid') bg-green-100 text-green-800
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
@endsection
