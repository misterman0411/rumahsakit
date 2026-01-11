@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Order Laboratorium</h1>
                <p class="text-gray-600 mt-2">{{ $laboratory->nomor_permintaan }}</p>
            </div>
            <div class="flex space-x-2">
                @if($laboratory->status === 'selesai')
                    <a href="{{ route('laboratory.print', $laboratory) }}" target="_blank"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak Hasil
                    </a>
                @endif
                @if($laboratory->status === 'menunggu')
                    <form action="{{ route('laboratory.collect-sample', $laboratory) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Ambil Sampel
                        </button>
                    </form>
                @endif
                @if($laboratory->status === 'sampel_diambil')
                    <button onclick="document.getElementById('resultsModal').classList.remove('hidden')"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Input Hasil
                    </button>
                @endif
                @if($laboratory->status === 'sedang_diproses' && ((auth()->user()->peran->nama ?? null) === 'doctor' || (auth()->user()->peran->nama ?? null) === 'admin'))
                    <form action="{{ route('laboratory.verify', $laboratory) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                            Verifikasi Hasil
                        </button>
                    </form>
                @endif
                @if($laboratory->status === 'selesai' && $laboratory->hasilLaboratorium->count() > 0)
                    <a href="{{ route('laboratory.print', $laboratory) }}" target="_blank"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                        </svg>
                        Cetak / Export
                    </a>
                @endif
                <a href="{{ route('laboratory.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Order Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Order</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nomor Order</p>
                            <p class="font-semibold">{{ $laboratory->nomor_permintaan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                @if($laboratory->status === 'selesai') bg-green-100 text-green-800
                                @elseif($laboratory->status === 'sedang_diproses') bg-blue-100 text-blue-800
                                @elseif($laboratory->status === 'sampel_diambil') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                @if($laboratory->status == 'menunggu') Menunggu
                                @elseif($laboratory->status == 'sampel_diambil') Sampel Diambil
                                @elseif($laboratory->status == 'sedang_diproses') Sedang Diproses
                                @elseif($laboratory->status == 'selesai') Selesai
                                @else {{ ucfirst($laboratory->status) }}
                                @endif
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jenis Pemeriksaan</p>
                            <p class="font-semibold">{{ $laboratory->jenisTes->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Order</p>
                            <p class="font-semibold">{{ $laboratory->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @if($laboratory->informasi_klinis)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500">Informasi Klinis</p>
                        <p class="text-gray-800 mt-1">{{ $laboratory->informasi_klinis }}</p>
                    </div>
                    @endif
                </div>

                <!-- Results -->
                @if($laboratory->hasilLaboratorium)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Hasil Pemeriksaan</h2>
                    <div class="bg-gray-50 p-4 rounded-lg space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Hasil</p>
                            <p class="font-semibold text-gray-800">{{ $laboratory->hasilLaboratorium->hasil }}</p>
                        </div>
                        @if($laboratory->hasilLaboratorium->nilai)
                        <div>
                            <p class="text-sm text-gray-500">Nilai</p>
                            <p class="font-semibold text-gray-800">
                                {{ $laboratory->hasilLaboratorium->nilai }}
                                @if($laboratory->hasilLaboratorium->satuan)
                                    {{ $laboratory->hasilLaboratorium->satuan }}
                                @endif
                            </p>
                        </div>
                        @endif
                        @if($laboratory->hasilLaboratorium->nilai_rujukan)
                        <div>
                            <p class="text-sm text-gray-500">Nilai Rujukan</p>
                            <p class="text-gray-800">{{ $laboratory->hasilLaboratorium->nilai_rujukan }}</p>
                        </div>
                        @endif
                        @if($laboratory->hasilLaboratorium->status)
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-2 py-1 rounded text-sm font-semibold
                                @if($laboratory->hasilLaboratorium->status === 'normal') bg-green-100 text-green-800
                                @elseif($laboratory->hasilLaboratorium->status === 'kritis') bg-red-100 text-red-800
                                @elseif($laboratory->hasilLaboratorium->status === 'tinggi') bg-orange-100 text-orange-800
                                @elseif($laboratory->hasilLaboratorium->status === 'rendah') bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($laboratory->hasilLaboratorium->status) }}
                            </span>
                        </div>
                        @endif
                        @if($laboratory->hasilLaboratorium->catatan)
                        <div>
                            <p class="text-sm text-gray-500">Catatan</p>
                            <p class="text-gray-800">{{ $laboratory->hasilLaboratorium->catatan }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Audit Trail / Riwayat Pemeriksaan -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Riwayat Pemeriksaan</h2>
                    <div class="space-y-4">
                        <!-- Order Created -->
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">Order Dibuat</p>
                                <p class="text-xs text-gray-500">{{ $laboratory->created_at->format('d/m/Y H:i') }}</p>
                                <p class="text-xs text-gray-600 mt-1">oleh Dr. {{ $laboratory->dokter->user->nama }}</p>
                            </div>
                        </div>

                        <!-- Sample Collected -->
                        @if($laboratory->sample_collected_at)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">Sampel Diambil</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($laboratory->sample_collected_at)->format('d/m/Y H:i') }}</p>
                                @if($laboratory->sampelDiambilOleh)
                                <p class="text-xs text-gray-600 mt-1">oleh {{ $laboratory->sampelDiambilOleh->nama }}</p>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Results Entered -->
                        @if($laboratory->waktu_input_hasil)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">Hasil Diinput</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($laboratory->waktu_input_hasil)->format('d/m/Y H:i') }}</p>
                                @if($laboratory->hasilDiinputOleh)
                                <p class="text-xs text-gray-600 mt-1">oleh {{ $laboratory->hasilDiinputOleh->nama }}</p>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Verified -->
                        @if($laboratory->waktu_verifikasi)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-800">Hasil Diverifikasi</p>
                                <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($laboratory->waktu_verifikasi)->format('d/m/Y H:i') }}</p>
                                @if($laboratory->diverifikasiOleh)
                                <p class="text-xs text-gray-600 mt-1">oleh Dr. {{ $laboratory->diverifikasiOleh->nama }}</p>
                                @endif
                            </div>
                        </div>
                        @endif
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
                            <p class="font-semibold">{{ $laboratory->pasien->no_rekam_medis }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold">{{ $laboratory->pasien->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jenis Kelamin</p>
                            <p>{{ $laboratory->pasien->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Lahir</p>
                            <p>{{ \Carbon\Carbon::parse($laboratory->pasien->tanggal_lahir)->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Doctor Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Dokter Pengirim</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Nama</p>
                            <p class="font-semibold">{{ $laboratory->dokter->user->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Spesialisasi</p>
                            <p>{{ $laboratory->dokter->spesialisasi }}</p>
                        </div>
                    </div>
                </div>

                <!-- Invoice -->
                @if($laboratory->tagihan)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Tagihan</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">No. Invoice</p>
                            <p class="font-semibold">{{ $laboratory->tagihan->nomor_tagihan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Total</p>
                            <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($laboratory->tagihan->total, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold
                                @if($laboratory->tagihan->status === 'lunas') bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                {{ ucfirst($laboratory->tagihan->status) }}
                            </span>
                        </div>
                        <a href="{{ route('billing.show', $laboratory->tagihan) }}"
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

<!-- Results Modal -->
<div id="resultsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-4xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-800">Input Hasil Laboratorium</h2>
        </div>
        <form action="{{ route('laboratory.enter-results', $laboratory) }}" method="POST">
            @csrf
            <div class="p-6">
                <div id="resultsContainer" class="space-y-4">
                    <div class="result-item border border-gray-200 rounded-lg p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Hasil *</label>
                                <input type="text" name="results[0][hasil]" required
                                    placeholder="Contoh: Glukosa Puasa"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nilai</label>
                                <input type="text" name="results[0][nilai]"
                                    placeholder="Contoh: 145"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Satuan</label>
                                <input type="text" name="results[0][satuan]"
                                    placeholder="Contoh: mg/dL"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nilai Rujukan</label>
                                <input type="text" name="results[0][nilai_rujukan]"
                                    placeholder="Contoh: 70-100"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select name="results[0][status]"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                    <option value="">Pilih Status</option>
                                    <option value="normal">Normal</option>
                                    <option value="tinggi">Tinggi</option>
                                    <option value="rendah">Rendah</option>
                                    <option value="kritis">Kritis</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan</label>
                                <textarea name="results[0][catatan]" rows="2"
                                    placeholder="Catatan tambahan (opsional)"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addResult()" class="mt-4 text-indigo-600 hover:text-indigo-700 font-semibold">
                    + Tambah Hasil Test
                </button>
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('resultsModal').classList.add('hidden')"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700">
                    Simpan Hasil
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let resultIndex = 1;
function addResult() {
    const container = document.getElementById('resultsContainer');
    const newResult = `
        <div class="result-item border border-gray-200 rounded-lg p-4">
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hasil *</label>
                    <input type="text" name="results[${resultIndex}][hasil]" required
                        placeholder="Contoh: Glukosa Puasa"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nilai</label>
                    <input type="text" name="results[${resultIndex}][nilai]"
                        placeholder="Contoh: 145"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Satuan</label>
                    <input type="text" name="results[${resultIndex}][satuan]"
                        placeholder="Contoh: mg/dL"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nilai Rujukan</label>
                    <input type="text" name="results[${resultIndex}][nilai_rujukan]"
                        placeholder="Contoh: 70-100"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="results[${resultIndex}][status]"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Pilih Status</option>
                        <option value="normal">Normal</option>
                        <option value="tinggi">Tinggi</option>
                        <option value="rendah">Rendah</option>
                        <option value="kritis">Kritis</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan</label>
                    <textarea name="results[${resultIndex}][catatan]" rows="2"
                        placeholder="Catatan tambahan (opsional)"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"></textarea>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newResult);
    resultIndex++;
}
</script>
@endsection
