<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
use App\Models\Medication;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'medication_id', 'quantity', 'price'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function medication()
    {
        return $this->belongsTo(Medication::class, 'medication_id');
    }
}
