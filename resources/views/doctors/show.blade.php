@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Dokter</h1>
                <p class="text-gray-600 mt-2">{{ $doctor->user->nama }}</p>
            </div>
            <div class="flex space-x-2">
                @if(auth()->user()->hasAnyRole(['admin', 'management']))
                <a href="{{ route('doctors.edit', $doctor) }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Edit
                </a>
                @endif
                @if(auth()->user()->hasRole('admin'))
                <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" 
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Hapus
                    </button>
                </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Doctor Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informasi Dokter</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Lengkap</p>
                            <p class="font-semibold text-lg">{{ $doctor->user->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-semibold">{{ $doctor->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Departemen</p>
                            <p class="font-semibold">{{ $doctor->departemen->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Spesialisasi</p>
                            <p class="font-semibold">{{ $doctor->spesialisasi }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nomor Lisensi (STR)</p>
                            <p class="font-semibold">{{ $doctor->nomor_lisensi }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nomor Telepon</p>
                            <p class="font-semibold">{{ $doctor->telepon }}</p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Biaya Konsultasi</p>
                            <p class="text-2xl font-bold text-indigo-600">Rp {{ number_format($doctor->consultation_fee, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Bergabung Sejak</p>
                            <p class="font-semibold">{{ $doctor->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Terakhir Update</p>
                            <p class="font-semibold">{{ $doctor->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Statistik</h2>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg text-center">
                            <p class="text-3xl font-bold text-blue-600">{{ $doctor->janjiTemu->count() }}</p>
                            <p class="text-sm text-gray-600 mt-1">Total Appointments</p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg text-center">
                            <p class="text-3xl font-bold text-green-600">{{ $doctor->rekamMedis->count() }}</p>
                            <p class="text-sm text-gray-600 mt-1">Rekam Medis</p>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg text-center">
                            <p class="text-3xl font-bold text-purple-600">{{ $doctor->reseps->count() }}</p>
                            <p class="text-sm text-gray-600 mt-1">Resep</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Appointments -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Appointments Terbaru</h2>
                    @if($doctor->janjiTemu->take(5)->count() > 0)
                        <div class="space-y-3">
                            @foreach($doctor->janjiTemu->take(5) as $appointment)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-semibold">{{ $appointment->pasien->nama }}</p>
                                    <p class="text-sm text-gray-600">{{ $appointment->janjiTemu_date->format('d M Y, H:i') }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    @if($appointment->status === 'completed') bg-green-100 text-green-800
                                    @elseif($appointment->status === 'in_progress') bg-blue-100 text-blue-800
                                    @elseif($appointment->status === 'checked_in') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('appointments.index', ['doctor_id' => $doctor->id]) }}" 
                            class="block text-center mt-4 text-indigo-600 hover:text-indigo-700 font-semibold">
                            Lihat Semua Appointments →
                        </a>
                    @else
                        <p class="text-gray-500 text-center py-8">Belum ada appointment</p>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h2>
                    <div class="space-y-2">
                        @if(auth()->user()->hasAnyRole(['front_office', 'admin']))
                        <a href="{{ route('appointments.create', ['doctor_id' => $doctor->id]) }}"
                            class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            Buat Appointment
                        </a>
                        @endif
                        @if(auth()->user()->hasAnyRole(['doctor', 'admin']))
                        <a href="{{ route('medical-records.create', ['doctor_id' => $doctor->id]) }}"
                            class="block w-full text-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            Tambah Rekam Medis
                        </a>
                        <a href="{{ route('prescriptions.create', ['doctor_id' => $doctor->id]) }}"
                            class="block w-full text-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            Tulis Resep
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Department Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Departemen</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-500">Nama Departemen</p>
                            <p class="font-semibold">{{ $doctor->departemen->nama }}</p>
                        </div>
                        @if($doctor->departemen->description)
                        <div>
                            <p class="text-sm text-gray-500">Deskripsi</p>
                            <p class="text-sm text-gray-800">{{ $doctor->departemen->description }}</p>
                        </div>
                        @endif
                        <a href="{{ route('departments.show', $doctor->department) }}"
                            class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                            Lihat Detail Departemen
                        </a>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Status Akun</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Status</span>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">Active</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Role</span>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">Doctor</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Last Login</span>
                            <span class="text-sm font-semibold">{{ $doctor->user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
