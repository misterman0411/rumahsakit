<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryResult extends Model
{
    use HasFactory;

    protected $table = 'hasil_laboratorium';

    protected $fillable = [
        'permintaan_id',
        'hasil',
        'nilai',
        'satuan',
        'nilai_rujukan',
        'status',
        'catatan',
        'diperiksa_oleh',
        'waktu_pemeriksaan',
    ];

    protected $casts = [
        'waktu_pemeriksaan' => 'datetime',
    ];

    public function permintaanLaboratorium()
    {
        return $this->belongsTo(LaboratoryOrder::class, 'permintaan_id');
    }

    public function dipriksaOleh()
    {
        return $this->belongsTo(User::class, 'diperiksa_oleh');
    }
}
