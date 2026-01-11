<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $table = 'resep';

    protected $fillable = [
        'nomor_resep',
        'pasien_id',
        'dokter_id',
        'kunjungan_id',
        'status',
        'catatan',
        'waktu_verifikasi',
        'diverifikasi_oleh',
        'waktu_penyerahan',
        'diserahkan_oleh',
        'alasan_penolakan',
        'ditolak_oleh',
        'waktu_penolakan',
    ];

    protected $casts = [
        'waktu_verifikasi' => 'datetime',
        'waktu_penyerahan' => 'datetime',
        'waktu_penolakan' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($prescription) {
            if (!$prescription->nomor_resep) {
                $prescription->nomor_resep = 'RS-' . date('Ymd') . '-' . str_pad(
                    Prescription::whereDate('created_at', today())->count() + 1,
                    4,
                    '0',
                    STR_PAD_LEFT
                );
            }
        });
    }

    public function kunjungan()
    {
        return $this->belongsTo(Visit::class, 'kunjungan_id');
    }

    public function pasien()
    {
        return $this->belongsTo(Patient::class, 'pasien_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Doctor::class, 'dokter_id');
    }

    public function itemResep()
    {
        return $this->hasMany(PrescriptionItem::class, 'resep_id');
    }

    public function diverifikasiOleh()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }

    public function diserahkanOleh()
    {
        return $this->belongsTo(User::class, 'diserahkan_oleh');
    }

    public function tagihan()
    {
        return $this->morphOne(Invoice::class, 'tagihan_untuk', 'tagihan_untuk_tipe', 'tagihan_untuk_id');
    }
}
