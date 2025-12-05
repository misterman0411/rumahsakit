<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InpatientDailyLog extends Model
{
    use HasFactory;

    protected $table = 'catatan_harian_rawat_inap';

    protected $fillable = [
        'rawat_inap_id',
        'perawat_id',
        'dokter_id',
        'tanggal',
        'waktu',
        'jenis',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function rawatInap()
    {
        return $this->belongsTo(InpatientAdmission::class, 'rawat_inap_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Doctor::class, 'dokter_id');
    }

    public function perawat()
    {
        return $this->belongsTo(Nurse::class, 'perawat_id');
    }
}
