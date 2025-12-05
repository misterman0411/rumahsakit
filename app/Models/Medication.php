<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $table = 'obat';

    protected $fillable = [
        'nama',
        'kode',
        'bentuk_sediaan',
        'kekuatan',
        'kategori',
        'deskripsi',
        'harga',
        'stok',
        'stok_minimum',
        'satuan',
        'tanggal_kadaluarsa',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
        'stok_minimum' => 'integer',
        'tanggal_kadaluarsa' => 'date',
    ];

    public function itemResep()
    {
        return $this->hasMany(PrescriptionItem::class, 'obat_id');
    }
}
