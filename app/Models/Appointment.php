<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'janji_temu';

    protected $fillable = [
        'nomor_janji_temu',
        'pasien_id',
        'dokter_id',
        'departemen_id',
        'tanggal_janji',
        'jenis',
        'status',
        'alasan',
        'catatan',
        'waktu_check_in',
        'nomor_antrian',
        'waktu_mulai_konsultasi',
        'kode_antrian',
    ];

    protected $casts = [
        'tanggal_janji' => 'datetime',
        'waktu_check_in' => 'datetime',
        'waktu_mulai_konsultasi' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($appointment) {
            if (!$appointment->nomor_janji_temu) {
                $appointment->nomor_janji_temu = 'JT-' . date('Ymd') . '-' . str_pad(
                    Appointment::whereDate('created_at', today())->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }

    public function pasien()
    {
        return $this->belongsTo(Patient::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Doctor::class, 'dokter_id');
    }

    public function departemen()
    {
        return $this->belongsTo(Department::class, 'departemen_id');
    }

    public function rekamMedis()
    {
        return $this->hasOne(MedicalRecord::class, 'janji_temu_id');
    }

    public function tagihan()
    {
        return $this->morphOne(Invoice::class, 'tagihan_untuk', 'tagihan_untuk_tipe', 'tagihan_untuk_id');
    }

    // Accessor untuk kompatibilitas dengan nama Inggris
    public function getPatientAttribute()
    {
        return $this->pasien;
    }

    public function getDoctorAttribute()
    {
        return $this->dokter;
    }

    public function getDepartmentAttribute()
    {
        return $this->departemen;
    }

    public function getDepartmentIdAttribute($value)
    {
        return $this->attributes['departemen_id'] ?? null;
    }

    public function getAppointmentDateAttribute()
    {
        return $this->tanggal_janji;
    }

    public function getQueueNumberAttribute()
    {
        return $this->nomor_antrian;
    }

    public function getCheckedInAtAttribute()
    {
        return $this->waktu_check_in;
    }

    public function getConsultationStartedAtAttribute()
    {
        return $this->waktu_mulai_konsultasi;
    }

    public function getQueueCodeAttribute()
    {
        return $this->kode_antrian;
    }

    public function getAppointmentNumberAttribute()
    {
        return $this->nomor_janji_temu;
    }
}
