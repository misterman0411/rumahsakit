<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCharge extends Model
{
    use HasFactory;

    protected $table = 'biaya_layanan';

    protected $fillable = [
        'nama_layanan',
        'kode',
        'kategori',
        'harga',
        'deskripsi',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];
}
