@extends('layouts.app')

@section('title', 'Add Charge')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-800">Add New Charge</h2>
        <p class="text-sm text-gray-600 mt-1">
            Patient: <span class="font-medium">{{ $inpatient->pasien->nama }}</span>
        </p>
    </div>

    <form action="{{ route('inpatient.charges.store', $inpatient) }}" method="POST" class="p-6">
        @csrf

        <div class="space-y-6">
            <!-- Charge Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Charge Date <span class="text-red-500">*</span>
                </label>
                <input type="date" name="charge_date" value="{{ old('charge_date', date('Y-m-d')) }}" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('charge_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Charge Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Charge Type <span class="text-red-500">*</span>
                </label>
                <select name="charge_type" id="charge_type" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Select Charge Type</option>
                    <option value="room" {{ old('charge_type') == 'room' ? 'selected' : '' }}>🛏️ Room</option>
                    <option value="doctor_visit" {{ old('charge_type') == 'doctor_visit' ? 'selected' : '' }}>👨‍⚕️ Doctor Visit</option>
                    <option value="medication" {{ old('charge_type') == 'medication' ? 'selected' : '' }}>💊 Medication</option>
                    <option value="procedure" {{ old('charge_type') == 'procedure' ? 'selected' : '' }}>🔬 Procedure</option>
                    <option value="lab" {{ old('charge_type') == 'lab' ? 'selected' : '' }}>🧪 Laboratory</option>
                    <option value="radiology" {{ old('charge_type') == 'radiology' ? 'selected' : '' }}>📸 Radiology</option>
                    <option value="nursing_care" {{ old('charge_type') == 'nursing_care' ? 'selected' : '' }}>👩‍⚕️ Nursing Care</option>
                    <option value="consultation" {{ old('charge_type') == 'consultation' ? 'selected' : '' }}>💬 Consultation</option>
                    <option value="other" {{ old('charge_type') == 'other' ? 'selected' : '' }}>📋 Other</option>
                </select>
                @error('charge_type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea name="description" rows="3" required
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Enter detailed description of the charge...">{{ old('description') }}</textarea>
                @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quantity and Unit Price -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Quantity <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="jumlah" id="quantity" value="{{ old('quantity', 1) }}" 
                        min="0" step="0.01" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('quantity')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Unit Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Unit Price (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="harga_satuan" id="unit_price" value="{{ old('unit_price', 0) }}" 
                        min="0" step="0.01" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('unit_price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Total Amount (Auto-calculated) -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-medium text-gray-700">Total Amount:</span>
                    <span class="text-2xl font-bold text-blue-900" id="total_amount">Rp 0</span>
                </div>
                <p class="text-xs text-gray-600 mt-1">Calculated automatically (Quantity × Unit Price)</p>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('inpatient.charges.index', $inpatient) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                Cancel
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                Add Charge
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const unitPriceInput = document.getElementById('unit_price');
    const totalAmountDisplay = document.getElementById('total_amount');

    function calculateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const total = quantity * unitPrice;
        
        totalAmountDisplay.textContent = 'Rp ' + total.toLocaleString('id-ID', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        });
    }

    quantityInput.addEventListener('input', calculateTotal);
    unitPriceInput.addEventListener('input', calculateTotal);

    // Calculate on page load
    calculateTotal();
});
</script>
@endsection
