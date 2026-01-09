@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg">
        <!-- Success Banner -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-8 text-center">
            <div class="flex justify-center mb-4">
                <div class="bg-white rounded-full p-4">
                    <i class="fas fa-check-circle text-green-500 text-6xl"></i>
                </div>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">Payment Successful!</h2>
            <p class="text-green-100 text-lg">{{ count($payments) }} invoice(s) have been paid successfully</p>
        </div>

        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-semibold text-gray-800">Payment Receipt</h2>
            <div class="flex gap-2">
                <a href="{{ route('billing.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Billing
                </a>
                <button onclick="window.print()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md no-print">
                    <i class="fas fa-print mr-2"></i>
                    Print Receipt
                </button>
            </div>
        </div>

        <div class="p-6">
            <!-- Payment Summary -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 pb-6 border-b">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Payment Date</label>
                            <p class="mt-1 text-gray-900">{{ $paymentDate->format('d F Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Payment Method</label>
                            <p class="mt-1 text-gray-900">
                                @if($paymentMethod === 'tunai')
                                    💵 Cash (Tunai)
                                @elseif($paymentMethod === 'kartu_kredit')
                                    💳 Credit Card
                                @elseif($paymentMethod === 'kartu_debit')
                                    💳 Debit Card
                                @elseif($paymentMethod === 'transfer')
                                    🏦 Bank Transfer
                                @elseif($paymentMethod === 'online')
                                    💳 Online Payment (Midtrans)
                                @elseif($paymentMethod === 'asuransi')
                                    🏥 Insurance
                                @else
                                    {{ ucfirst($paymentMethod) }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Processed By</label>
                            <p class="mt-1 text-gray-900">{{ $processedBy->nama ?? 'System' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Total Invoices Paid</label>
                            <p class="mt-1 text-lg font-bold text-green-600">{{ count($payments) }} invoice(s)</p>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Name</label>
                            <p class="mt-1 text-gray-900 font-semibold">{{ $patient->nama }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">MRN</label>
                            <p class="mt-1 text-gray-900">{{ $patient->no_rekam_medis }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Phone</label>
                            <p class="mt-1 text-gray-900">{{ $patient->telepon ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice & Payment Details -->
            <div class="mb-6 pb-6 border-b">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Details</h3>
                <div class="space-y-4">
                    @foreach($payments as $payment)
                    @php
                        $invoice = $payment->tagihan;
                    @endphp
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <p class="font-bold text-gray-800 text-lg">{{ $invoice->nomor_tagihan }}</p>
                                <p class="text-sm text-gray-600">
                                    <i class="far fa-calendar mr-1"></i>
                                    {{ $invoice->created_at->format('d M Y H:i') }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Payment #{{ $payment->nomor_pembayaran }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-xl font-bold text-green-600">Rp {{ number_format($payment->jumlah, 0, ',', '.') }}</p>
                                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                    Lunas
                                </span>
                            </div>
                        </div>

                        @if($invoice->itemTagihan && $invoice->itemTagihan->count() > 0)
                        <div class="border-t border-gray-200 pt-3 mt-3">
                            <p class="text-xs font-semibold text-gray-600 mb-2">Service Details:</p>
                            <div class="space-y-1">
                                @foreach($invoice->itemTagihan as $item)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-700">• {{ $item->deskripsi }}</span>
                                    <span class="text-gray-600 font-medium">Rp {{ number_format($item->total, 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Total Summary -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Summary</h3>
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-lg p-6 border-2 border-green-200">
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-700">
                            <span>Total Invoices:</span>
                            <span class="font-semibold">{{ count($payments) }} invoice(s)</span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal:</span>
                            <span class="font-semibold">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t-2 border-green-300 pt-3 flex justify-between items-center">
                            <span class="text-xl font-bold text-gray-900">Total Paid:</span>
                            <span class="text-3xl font-bold text-green-600">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-center gap-4 no-print">
                <a href="{{ route('billing.index') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">
                    <i class="fas fa-list mr-2"></i>
                    View All Invoices
                </a>
                <button onclick="window.print()" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium">
                    <i class="fas fa-print mr-2"></i>
                    Print Receipt
                </button>
            </div>

            <!-- Footer Note -->
            <div class="mt-6 pt-6 border-t text-center text-sm text-gray-500">
                <p>Thank you for your payment. All invoices have been marked as paid.</p>
                <p class="mt-1">If you have any questions, please contact our billing department.</p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    body {
        background: white;
    }
    .shadow {
        box-shadow: none !important;
    }
}
</style>
@endsection
