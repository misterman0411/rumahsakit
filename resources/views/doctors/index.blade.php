@extends('layouts.app')

@section('title', 'Doctors')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-2xl font-semibold text-gray-800">Doctors</h2>
        <a href="{{ route('doctors.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
            Add Doctor
        </a>
    </div>

    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($doctors as $doctor)
            <div class="border border-gray-200 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $doctor->user->nama }}</h3>
                <p class="text-sm text-gray-600">{{ $doctor->spesialisasi }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $doctor->departemen->nama }}</p>
                <p class="text-sm text-gray-500">License: {{ $doctor->nomor_lisensi }}</p>
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('doctors.show', $doctor) }}" class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                    <a href="{{ route('doctors.edit', $doctor) }}" class="text-green-600 hover:text-green-900 text-sm">Edit</a>
                </div>
            </div>
            @empty
            <p class="col-span-3 text-center text-gray-500">No doctors found</p>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $doctors->links() }}
        </div>
    </div>
</div>
@endsection
