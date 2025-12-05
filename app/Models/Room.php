<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'ruangan';

    protected $fillable = [
        'nama',
        'nomor_ruangan',
        'departemen_id',
        'jenis',
        'tarif_per_hari',
        'kapasitas',
        'status',
    ];

    protected $casts = [
        'kapasitas' => 'integer',
        'tarif_per_hari' => 'decimal:2',
    ];

    public function departemen()
    {
        return $this->belongsTo(Department::class, 'departemen_id');
    }

    public function tempatTidur()
    {
        return $this->hasMany(Bed::class, 'ruangan_id');
    }

    public function rawatInap()
    {
        return $this->hasMany(InpatientAdmission::class, 'ruangan_id');
    }
}
