<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VitalSign extends Model
{
    use HasFactory;

    protected $table = 'tanda_vital';

    protected $fillable = [
        'pasien_id',
        'perawat_id',
        'rawat_inap_id',
        'suhu',
        'tekanan_darah_sistolik',
        'tekanan_darah_diastolik',
        'detak_jantung',
        'laju_pernapasan',
        'saturasi_oksigen',
        'berat_badan',
        'tinggi_badan',
        'catatan',
        'waktu_pengukuran',
    ];

    protected $casts = [
        'suhu' => 'decimal:2',
        'saturasi_oksigen' => 'decimal:2',
        'berat_badan' => 'decimal:2',
        'tinggi_badan' => 'decimal:2',
        'waktu_pengukuran' => 'datetime',
    ];

    public function pasien()
    {
        return $this->belongsTo(Patient::class, 'pasien_id');
    }

    public function perawat()
    {
        return $this->belongsTo(Nurse::class, 'perawat_id');
    }

    public function rawatInap()
    {
        return $this->belongsTo(InpatientAdmission::class, 'rawat_inap_id');
    }

    // Auto calculate BMI
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($vitalSign) {
            if ($vitalSign->berat_badan && $vitalSign->tinggi_badan) {
                $heightInMeters = $vitalSign->tinggi_badan / 100;
                $vitalSign->bmi = round($vitalSign->berat_badan / ($heightInMeters * $heightInMeters), 2);
            }
        });
    }
}
