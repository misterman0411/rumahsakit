<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'tagihan';

    protected $fillable = [
        'nomor_tagihan',
        'pasien_id',
        'tagihan_untuk_id',
        'tagihan_untuk_tipe',
        'subtotal',
        'diskon',
        'pajak',
        'total',
        'status',
        'jatuh_tempo',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'diskon' => 'decimal:2',
        'pajak' => 'decimal:2',
        'total' => 'decimal:2',
        'jatuh_tempo' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (!$invoice->nomor_tagihan) {
                $invoice->nomor_tagihan = 'INV-' . date('Ymd') . '-' . str_pad(
                    Invoice::whereDate('created_at', today())->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Patient::class, 'pasien_id');
    }

    public function tagihanUntuk()
    {
        return $this->morphTo();
    }

    public function itemTagihan()
    {
        return $this->hasMany(InvoiceItem::class, 'tagihan_id');
    }

    public function pembayaran()
    {
        return $this->hasMany(Payment::class, 'tagihan_id');
    }
}
