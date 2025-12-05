<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'item_tagihan';

    protected $fillable = [
        'tagihan_id',
        'deskripsi',
        'jumlah',
        'harga_satuan',
        'total',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga_satuan' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Invoice::class, 'tagihan_id');
    }
}
