<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'dokter';

    protected $fillable = [
        'user_id',
        'departemen_id',
        'spesialisasi',
        'nomor_izin_praktik',
        'telepon',
        'biaya_konsultasi',
    ];

    protected $casts = [
        'biaya_konsultasi' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Department::class, 'departemen_id');
    }

    public function janjiTemu()
    {
        return $this->hasMany(Appointment::class, 'dokter_id');
    }

    public function rekamMedis()
    {
        return $this->hasMany(MedicalRecord::class, 'dokter_id');
    }
}
