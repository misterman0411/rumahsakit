@extends('layouts.app')

@section('title', 'Medications')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Medications</h1>
                <p class="text-gray-600 mt-2">Manajemen data dan stok obat</p>
            </div>
            @if(auth()->user()->hasRole('pharmacist') || auth()->user()->hasRole('admin'))
            <a href="{{ route('medications.create') }}" 
               class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:shadow-lg transition-all font-semibold">
                + Add Medication
            </a>
            @endif
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('medications.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                           placeholder="Cari nama atau kode obat...">
                </div>

                <div class="flex items-end gap-3">
                    <div class="flex-1">
                        <label class="flex items-center">
                            <input type="checkbox" name="low_stock" value="1" {{ request('low_stock') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 mr-2">
                            <span class="text-sm font-semibold text-gray-700">Stok Menipis</span>
                        </label>
                    </div>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-semibold">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Medications Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Obat</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Bentuk/Kekuatan</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($medications as $medication)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $medication->nama }}</div>
                                <div class="text-xs text-gray-500">{{ $medication->kode }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <div>{{ $medication->bentuk_sediaan }}</div>
                                <div class="text-xs text-gray-500">{{ $medication->kekuatan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="text-sm font-bold {{ $medication->stok < $medication->stok_minimum ? 'text-red-600' : 'text-gray-900' }}">
                                    {{ number_format($medication->stok, 0) }} {{ $medication->satuan }}
                                </div>
                                @if($medication->stok < $medication->stok_minimum)
                                <div class="text-xs text-red-500 font-semibold">⚠ Stok Minimum: {{ $medication->stok_minimum }}</div>
                                @else
                                <div class="text-xs text-gray-500">Min: {{ $medication->stok_minimum }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-gray-900">
                                Rp {{ number_format($medication->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                <a href="{{ route('medications.show', $medication) }}" 
                                   class="text-blue-600 hover:text-blue-900 font-semibold">View</a>
                                @if(auth()->user()->hasRole('pharmacist') || auth()->user()->hasRole('admin'))
                                <a href="{{ route('medications.edit', $medication) }}" 
                                   class="text-green-600 hover:text-green-900 font-semibold">Edit</a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                </svg>
                                <p class="mt-4 text-gray-500 font-medium">Belum ada data obat</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($medications->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $medications->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
