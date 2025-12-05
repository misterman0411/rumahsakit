<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departemen';

    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
    ];

    public function dokter()
    {
        return $this->hasMany(Doctor::class, 'departemen_id');
    }

    public function janjiTemu()
    {
        return $this->hasMany(Appointment::class, 'departemen_id');
    }
}
