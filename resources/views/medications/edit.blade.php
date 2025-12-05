@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Medication</h1>
            <p class="text-gray-600 mt-2">Update medication information</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('medications.update', $medication) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="p-6 space-y-6">
                    <!-- Medication Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Medication Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="name" required value="{{ old('nama', $medication->nama) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Generic Name -->
                    <div>
                        <label for="generic_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Generic Name
                        </label>
                        <input type="text" name="generic_name" id="generic_name" value="{{ old('generic_name', $medication->generic_name) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        @error('generic_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-semibold text-gray-700 mb-2">
                                Type <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <option value="tablet" {{ old('type', $medication->type) == 'tablet' ? 'selected' : '' }}>Tablet</option>
                                <option value="capsule" {{ old('type', $medication->type) == 'capsule' ? 'selected' : '' }}>Capsule</option>
                                <option value="syrup" {{ old('type', $medication->type) == 'syrup' ? 'selected' : '' }}>Syrup</option>
                                <option value="injection" {{ old('type', $medication->type) == 'injection' ? 'selected' : '' }}>Injection</option>
                                <option value="cream" {{ old('type', $medication->type) == 'cream' ? 'selected' : '' }}>Cream/Ointment</option>
                                <option value="drops" {{ old('type', $medication->type) == 'drops' ? 'selected' : '' }}>Drops</option>
                                <option value="inhaler" {{ old('type', $medication->type) == 'inhaler' ? 'selected' : '' }}>Inhaler</option>
                                <option value="other" {{ old('type', $medication->type) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dosage -->
                        <div>
                            <label for="dosage" class="block text-sm font-semibold text-gray-700 mb-2">
                                Dosage <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="dosage" id="dosage" required value="{{ old('dosage', $medication->dosage) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('dosage')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Unit Price -->
                        <div>
                            <label for="unit_price" class="block text-sm font-semibold text-gray-700 mb-2">
                                Unit Price (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" step="0.01" name="harga_satuan" id="unit_price" required value="{{ old('unit_price', $medication->harga_satuan) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('unit_price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Stock Quantity -->
                        <div>
                            <label for="stock_quantity" class="block text-sm font-semibold text-gray-700 mb-2">
                                Stock Quantity <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stock_quantity" id="stock_quantity" required value="{{ old('stock_quantity', $medication->stock_quantity) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('stock_quantity')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Minimum Stock -->
                        <div>
                            <label for="minimum_stock" class="block text-sm font-semibold text-gray-700 mb-2">
                                Minimum Stock Level
                            </label>
                            <input type="number" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', $medication->minimum_stock) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('minimum_stock')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Expiry Date -->
                        <div>
                            <label for="expiry_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                Expiry Date
                            </label>
                            <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $medication->expiry_date?->format('Y-m-d')) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('expiry_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Manufacturer -->
                    <div>
                        <label for="manufacturer" class="block text-sm font-semibold text-gray-700 mb-2">
                            Manufacturer
                        </label>
                        <input type="text" name="manufacturer" id="manufacturer" value="{{ old('manufacturer', $medication->manufacturer) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        @error('manufacturer')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('description', $medication->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                            Status
                        </label>
                        <select name="status" id="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <option value="available" {{ old('status', $medication->status) == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="out_of_stock" {{ old('status', $medication->status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            <option value="discontinued" {{ old('status', $medication->status) == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('medications.show', $medication) }}"
                        class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all">
                        Update Medication
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
