<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadiologyTestType extends Model
{
    use HasFactory;

    protected $table = 'jenis_tes_radiologi';

    protected $fillable = [
        'nama',
        'kode',
        'kategori',
        'deskripsi',
        'harga',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function permintaanRadiologi()
    {
        return $this->hasMany(RadiologyOrder::class, 'jenis_tes_id');
    }
}
