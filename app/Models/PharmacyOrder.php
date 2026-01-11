<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PharmacyOrder extends Model
{
    protected $fillable = [
        'user_id',
        'invoice_number',
        'total_amount',
        'status',
        'payment_status',
        'shipping_address',
        'shipping_phone',
        'snap_token',
        'payment_method',
        'delivery_method'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(PharmacyOrderItem::class);
    }
}
