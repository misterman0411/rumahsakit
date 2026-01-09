<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadiologyOrder extends Model
{
    use HasFactory;

    protected $table = 'permintaan_radiologi';

    protected $fillable = [
        'nomor_permintaan',
        'pasien_id',
        'dokter_id',
        'jenis_tes_id',
        'kunjungan_id',
        'status',
        'catatan_klinis',
        'hasil',
        'interpretasi',
        'diperiksa_oleh',
        'waktu_pemeriksaan',
    ];

    protected $casts = [
        'waktu_pemeriksaan' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->nomor_permintaan) {
                $order->nomor_permintaan = 'RAD-' . date('Ymd') . '-' . str_pad(
                    RadiologyOrder::whereDate('created_at', today())->count() + 1,
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

    public function jenisTes()
    {
        return $this->belongsTo(RadiologyTestType::class, 'jenis_tes_id');
    }

    public function diperiksaOleh()
    {
        return $this->belongsTo(User::class, 'diperiksa_oleh');
    }

    public function tagihan()
    {
        return $this->morphOne(Invoice::class, 'tagihan_untuk', 'tagihan_untuk_tipe', 'tagihan_untuk_id');
    }
}
