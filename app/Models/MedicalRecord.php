<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'janji_temu_id',
        'keluhan',
        'tanda_vital',
        'diagnosis',
        'kode_icd10',
        'kode_icd9',
        'rencana_perawatan',
        'catatan',
    ];

    protected $casts = [
        'tanda_vital' => 'array',
    ];

    public function pasien()
    {
        return $this->belongsTo(Patient::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Doctor::class, 'dokter_id');
    }

    public function janjiTemu()
    {
        return $this->belongsTo(Appointment::class, 'janji_temu_id');
    }
}
