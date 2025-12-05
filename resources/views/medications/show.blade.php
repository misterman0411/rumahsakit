@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $medication->nama }}</h1>
                <p class="text-gray-600 mt-2">{{ $medication->generic_name ?? 'Medication Details' }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('medications.edit', $medication) }}" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Edit
                </a>
                <a href="{{ route('medications.index') }}" 
                    class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                    Back to List
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Basic Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Medication Name</p>
                            <p class="font-semibold text-gray-900">{{ $medication->nama }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Generic Name</p>
                            <p class="font-semibold text-gray-900">{{ $medication->generic_name ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Type</p>
                            <p class="font-semibold text-gray-900">{{ ucfirst($medication->type) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Dosage</p>
                            <p class="font-semibold text-gray-900">{{ $medication->dosage }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Manufacturer</p>
                            <p class="font-semibold text-gray-900">{{ $medication->manufacturer ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold
                                @if($medication->status == 'available') bg-green-100 text-green-800
                                @elseif($medication->status == 'out_of_stock') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucwords(str_replace('_', ' ', $medication->status)) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Stock & Pricing -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Stock & Pricing</h2>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-lg">
                            <p class="text-sm text-blue-900 mb-1">Unit Price</p>
                            <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($medication->harga_satuan, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-lg">
                            <p class="text-sm text-green-900 mb-1">Stock Quantity</p>
                            <p class="text-2xl font-bold text-green-900">{{ $medication->stock_quantity }}</p>
                        </div>
                        <div class="bg-gradient-to-br from-orange-50 to-orange-100 p-4 rounded-lg">
                            <p class="text-sm text-orange-900 mb-1">Minimum Stock</p>
                            <p class="text-2xl font-bold text-orange-900">{{ $medication->minimum_stock ?? 0 }}</p>
                        </div>
                    </div>
                    
                    @if($medication->stock_quantity <= $medication->minimum_stock)
                        <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="font-semibold text-red-900">Low Stock Alert!</span>
                            </div>
                            <p class="text-sm text-red-700 mt-1">Stock is below minimum level. Please reorder.</p>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                @if($medication->description)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Description</h2>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $medication->description }}</p>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Expiry Info -->
                @if($medication->expiry_date)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Expiry Information</h2>
                    <div class="text-center">
                        <p class="text-sm text-gray-600">Expiry Date</p>
                        <p class="text-2xl font-bold text-gray-900 mt-2">{{ $medication->expiry_date->format('d M Y') }}</p>
                        @php
                            $daysUntilExpiry = now()->diffInDays($medication->expiry_date, false);
                        @endphp
                        @if($daysUntilExpiry < 0)
                            <span class="inline-block mt-2 px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                Expired {{ abs($daysUntilExpiry) }} days ago
                            </span>
                        @elseif($daysUntilExpiry <= 30)
                            <span class="inline-block mt-2 px-3 py-1 bg-orange-100 text-orange-800 text-xs font-semibold rounded-full">
                                Expires in {{ $daysUntilExpiry }} days
                            </span>
                        @else
                            <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                {{ $daysUntilExpiry }} days remaining
                            </span>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="{{ route('medications.edit', $medication) }}" 
                            class="block w-full px-4 py-2 bg-blue-600 text-white text-center rounded-lg hover:bg-blue-700 transition-colors">
                            Edit Medication
                        </a>
                        <form action="{{ route('medications.destroy', $medication) }}" method="POST" 
                            onsubmit="return confirm('Are you sure you want to delete this medication?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                class="block w-full px-4 py-2 bg-red-600 text-white text-center rounded-lg hover:bg-red-700 transition-colors">
                                Delete Medication
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Record Info -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-bold text-gray-800 mb-4">Record Information</h2>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-600">Created</p>
                            <p class="font-semibold text-gray-900">{{ $medication->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Last Updated</p>
                            <p class="font-semibold text-gray-900">{{ $medication->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
