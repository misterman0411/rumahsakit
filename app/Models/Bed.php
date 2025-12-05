<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    use HasFactory;

    protected $table = 'tempat_tidur';

    protected $fillable = [
        'ruangan_id',
        'nomor_tempat_tidur',
        'status',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Room::class, 'ruangan_id');
    }

    public function rawatInap()
    {
        return $this->hasMany(InpatientAdmission::class, 'tempat_tidur_id');
    }
}
