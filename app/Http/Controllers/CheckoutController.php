<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\PharmacyOrder;
use App\Models\PharmacyOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melanjutkan pembayaran.');
        }

        $cart = Cart::where('user_id', $user->id)->first();

        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('shop.index')->with('error', 'Keranjang belanja kosong.');
        }

        return view('shop.checkout', compact('cart', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_phone' => 'required|string|max:20',
            'delivery_method' => 'required|in:pickup,delivery',
            'payment_method' => 'required|in:qris,debit,credit,cash',
            'shipping_address' => 'required_if:delivery_method,delivery|nullable|string|max:500',
        ]);

        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->firstOrFail();
        
        if ($cart->items->count() == 0) {
            return redirect()->route('shop.index')->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();
        try {
            $totalAmount = $cart->items->sum(function($item) {
                return $item->price * $item->quantity;
            });

            // Handle pickup address or use submitted address
            $shippingAddress = $request->delivery_method === 'pickup' 
                ? 'AMBIL DI APOTEK (PICK UP)' 
                : $request->shipping_address;

            $order = PharmacyOrder::create([
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . strtoupper(Str::random(10)),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'shipping_address' => $shippingAddress,
                'shipping_phone' => $request->shipping_phone,
                'payment_method' => $request->payment_method,
                'delivery_method' => $request->delivery_method,
            ]);

            foreach ($cart->items as $item) {
                PharmacyOrderItem::create([
                    'pharmacy_order_id' => $order->id,
                    'medication_id' => $item->medication_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);
            }

            // Clear cart items
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('shop.index')->with('success', 'Pesanan berhasil dibuat! ID Pesanan: ' . $order->invoice_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage());
        }
    }
}
