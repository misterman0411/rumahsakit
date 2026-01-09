@extends('layouts.app')

@section('title', 'Billing Charges - ' . $inpatient->pasien->nama)

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Billing & Charges</h2>
            <p class="text-sm text-gray-600 mt-1">
                Patient: <span class="font-medium">{{ $inpatient->pasien->nama }}</span> | 
                Admission: <span class="font-medium">{{ $inpatient->tanggal_masuk->format('d M Y') }}</span>
            </p>
        </div>
        @if(auth()->user()->hasAnyRole(['cashier', 'nurse', 'doctor', 'admin']))
        <a href="{{ route('inpatient.charges.create', $inpatient) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
            + Add Charge
        </a>
        @endif
    </div>

    <!-- Summary Cards by Type -->
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Charge Summary</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($summary as $type => $data)
            <div class="border rounded-lg p-4 
                @if($type == 'room') bg-blue-50 border-blue-200
                @elseif($type == 'doctor_visit') bg-green-50 border-green-200
                @elseif($type == 'medication') bg-purple-50 border-purple-200
                @elseif($type == 'procedure') bg-indigo-50 border-indigo-200
                @elseif($type == 'lab') bg-yellow-50 border-yellow-200
                @elseif($type == 'radiology') bg-pink-50 border-pink-200
                @elseif($type == 'nursing_care') bg-teal-50 border-teal-200
                @elseif($type == 'consultation') bg-orange-50 border-orange-200
                @else bg-gray-50 border-gray-200 @endif">
                
                <div class="flex items-center justify-between mb-2">
                    <div class="text-2xl">
                        @if($type == 'room') 🛏️
                        @elseif($type == 'doctor_visit') 👨‍⚕️
                        @elseif($type == 'medication') 💊
                        @elseif($type == 'procedure') 🔬
                        @elseif($type == 'lab') 🧪
                        @elseif($type == 'radiology') 📸
                        @elseif($type == 'nursing_care') 👩‍⚕️
                        @elseif($type == 'consultation') 💬
                        @else 📋 @endif
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-gray-600">{{ $data['count'] }}x</div>
                    </div>
                </div>
                <div class="text-xs font-medium text-gray-700 mb-1">
                    {{ ucfirst(str_replace('_', ' ', $type)) }}
                </div>
                <div class="text-lg font-bold
                    @if($type == 'room') text-blue-800
                    @elseif($type == 'doctor_visit') text-green-800
                    @elseif($type == 'medication') text-purple-800
                    @elseif($type == 'procedure') text-indigo-800
                    @elseif($type == 'lab') text-yellow-800
                    @elseif($type == 'radiology') text-pink-800
                    @elseif($type == 'nursing_care') text-teal-800
                    @elseif($type == 'consultation') text-orange-800
                    @else text-gray-800 @endif">
                    Rp {{ number_format($data['total'], 0, ',', '.') }}
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Grand Total -->
    <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <div>
                <div class="text-sm text-gray-600">Grand Total</div>
                <div class="text-xs text-gray-500 mt-1">
                    Total {{ $charges->count() }} charges
                </div>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold text-blue-900">
                    Rp {{ number_format($charges->sum('total'), 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Charges Table -->
    <div class="p-6">
        @if($charges->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Qty</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                        @if(auth()->user()->hasAnyRole(['cashier', 'admin']))
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($charges as $charge)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($charge->tanggal)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($charge->jenis_biaya == 'room') bg-blue-100 text-blue-800
                                @elseif($charge->jenis_biaya == 'doctor_visit') bg-green-100 text-green-800
                                @elseif($charge->jenis_biaya == 'medication') bg-purple-100 text-purple-800
                                @elseif($charge->jenis_biaya == 'procedure') bg-indigo-100 text-indigo-800
                                @elseif($charge->jenis_biaya == 'lab') bg-yellow-100 text-yellow-800
                                @elseif($charge->jenis_biaya == 'radiology') bg-pink-100 text-pink-800
                                @elseif($charge->jenis_biaya == 'nursing_care') bg-teal-100 text-teal-800
                                @elseif($charge->jenis_biaya == 'consultation') bg-orange-100 text-orange-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $charge->jenis_biaya)) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $charge->deskripsi }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 text-right">{{ $charge->jumlah }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900 text-right">
                            Rp {{ number_format($charge->harga_satuan, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-900 text-right">
                            Rp {{ number_format($charge->total, 0, ',', '.') }}
                        </td>
                        @if(auth()->user()->hasAnyRole(['cashier', 'admin']))
                        <td class="px-4 py-3 text-center">
                            <form action="{{ route('inpatient.charges.destroy', [$inpatient, $charge]) }}" method="POST" 
                                onsubmit="return confirm('Are you sure you want to delete this charge?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="5" class="px-4 py-3 text-right text-sm font-bold text-gray-900">Grand Total:</td>
                        <td class="px-4 py-3 text-right text-lg font-bold text-blue-900">
                            Rp {{ number_format($charges->sum('total'), 0, ',', '.') }}
                        </td>
                        @if(auth()->user()->hasAnyRole(['cashier', 'admin']))
                        <td></td>
                        @endif
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No charges yet</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by adding a new charge.</p>
        </div>
        @endif
    </div>
</div>
@endsection
