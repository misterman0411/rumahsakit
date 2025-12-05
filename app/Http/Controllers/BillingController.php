<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with(['pasien', 'tagihanUntuk']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('pasien_id')) {
            $query->where('pasien_id', $request->pasien_id);
        }

        $invoices = $query->latest()->paginate(20);
        $patients = Patient::orderBy('nama')->get();

        return view('billing.index', compact('invoices', 'patients'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['pasien', 'tagihanUntuk', 'pembayaran']);

        return view('billing.show', compact('invoice'));
    }

    public function payment(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'jumlah' => 'required|numeric|min:0|max:' . $invoice->total,
            'metode_pembayaran' => ['required', Rule::in(Payment::PAYMENT_METHODS)],
            'tanggal_pembayaran' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $payment = Payment::create([
                'pasien_id' => $invoice->pasien_id,
                'jumlah' => $validated['jumlah'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
                'catatan' => $validated['catatan'] ?? null,
                'diproses_oleh' => Auth::id(),
            ]);

            // Attach payment to invoice
            $payment->tagihan()->attach($invoice->id);

            // Update invoice status if fully paid
            if ($validated['jumlah'] >= $invoice->total) {
                $invoice->update(['status' => 'paid']);
            } else {
                $invoice->update(['status' => 'partially_paid']);
            }

            DB::commit();

            return redirect()->route('billing.show', $invoice)
                ->with('success', 'Pembayaran berhasil diproses dengan nomor: ' . $payment->nomor_pembayaran);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage())->withInput();
        }
    }

    public function paymentMultiple(Request $request)
    {
        $validated = $request->validate([
            'tagihan_ids' => 'required|array|min:1',
            'tagihan_ids.*' => 'exists:tagihan,id',
            'metode_pembayaran' => ['required', Rule::in(Payment::PAYMENT_METHODS)],
            'tanggal_pembayaran' => 'required|date',
            'catatan' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $invoices = Invoice::whereIn('id', $validated['tagihan_ids'])->get();
            $totalAmount = $invoices->sum('total');

            $payment = Payment::create([
                'pasien_id' => $invoices->first()->pasien_id,
                'jumlah' => $totalAmount,
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'tanggal_pembayaran' => $validated['tanggal_pembayaran'],
                'catatan' => $validated['catatan'] ?? null,
                'processed_by' => Auth::id(),
            ]);

            // Attach payment to all invoices
            $payment->invoices()->attach($validated['invoice_ids']);

            // Update all invoices to paid
            Invoice::whereIn('id', $validated['invoice_ids'])->update(['status' => 'paid']);

            DB::commit();

            return redirect()->route('billing.index')
                ->with('success', "Pembayaran {$invoices->count()} invoice berhasil diproses dengan nomor: {$payment->payment_number}");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage())->withInput();
        }
    }

    public function payments(Request $request)
    {
        $query = Payment::with(['patient', 'invoices', 'processor']);

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $payments = $query->latest('payment_date')->paginate(20);

        return view('billing.payments', compact('payments'));
    }
}
