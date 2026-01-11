<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        return view('shop.cart', compact('cart'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'medication_id' => 'required|exists:obat,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $medication = Medication::findOrFail($request->medication_id);
        $cart = $this->getCart(true);

        $cartItem = $cart->items()->where('medication_id', $medication->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'medication_id' => $medication->id,
                'quantity' => $request->quantity,
                'price' => $medication->harga
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Obat berhasil ditambahkan ke keranjang',
                'cart_count' => $cart->items()->count()
            ]);
        }

        return redirect()->back()->with('success', 'Obat berhasil ditambahkan ke keranjang');
    }

    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::findOrFail($id);
        
        // Ensure item belongs to current user's cart
        if ($cartItem->cart_id !== $this->getCart()->id) {
            abort(403);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui');
    }

    public function removeFromCart($id)
    {
        $cartItem = CartItem::findOrFail($id);
        
        if ($cartItem->cart_id !== $this->getCart()->id) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item dihapus dari keranjang');
    }

    private function getCart($create = false)
    {
        $user = Auth::user();
        
        if ($user) {
            $cart = Cart::where('user_id', $user->id)->first();
            if (!$cart && $create) {
                $cart = Cart::create(['user_id' => $user->id]);
            }
        } else {
            $sessionId = Session::getId();
            $cart = Cart::where('session_id', $sessionId)->first();
            if (!$cart && $create) {
                $cart = Cart::create(['session_id' => $sessionId]);
            }
        }

        return $cart;
    }
}
