<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InpatientCharge extends Model
{
    use HasFactory;

    protected $table = 'biaya_rawat_inap';

    protected $fillable = [
        'rawat_inap_id',
        'jenis_biaya',
        'deskripsi',
        'jumlah',
        'harga_satuan',
        'total',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'integer',
        'harga_satuan' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function rawatInap()
    {
        return $this->belongsTo(InpatientAdmission::class, 'rawat_inap_id');
    }

    public function referensi()
    {
        return $this->morphTo();
    }

    // Auto calculate total before saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($charge) {
            $charge->total = $charge->jumlah * $charge->harga_satuan;
        });
    }
}
