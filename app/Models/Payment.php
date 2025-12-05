<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    const METODE_PEMBAYARAN = [
        'tunai',
        'transfer',
        'kartu_debit',
        'kartu_kredit',
        'bpjs',
        'asuransi',
    ];

    const PAYMENT_METHODS = [
        'tunai',
        'transfer',
        'kartu_debit',
        'kartu_kredit',
        'bpjs',
        'asuransi',
    ];

    protected $fillable = [
        'nomor_pembayaran',
        'tagihan_id',
        'jumlah',
        'metode_pembayaran',
        'tanggal_pembayaran',
        'nomor_referensi',
        'catatan',
        'diterima_oleh',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'tanggal_pembayaran' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            if (!$payment->nomor_pembayaran) {
                $payment->nomor_pembayaran = 'PAY-' . date('Ymd') . '-' . str_pad(
                    Payment::whereDate('created_at', today())->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }

    public function tagihan()
    {
        return $this->belongsTo(Invoice::class, 'tagihan_id');
    }

    public function diterimaOleh()
    {
        return $this->belongsTo(User::class, 'diterima_oleh');
    }
}
