<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabTestType extends Model
{
    use HasFactory;

    protected $table = 'jenis_tes_laboratorium';

    protected $fillable = [
        'nama',
        'kode',
        'kategori',
        'deskripsi',
        'harga',
        'nilai_normal',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function permintaanLaboratorium()
    {
        return $this->hasMany(LaboratoryOrder::class, 'jenis_tes_id');
    }
}
