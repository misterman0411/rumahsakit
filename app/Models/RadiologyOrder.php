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
        'image_path',
        'report_status',
        'signed_by',
        'signed_at',
        'version',
        'parent_revision_id',
        'hasil_diinput_oleh',
        'waktu_input_hasil',
    ];

    protected $casts = [
        'waktu_pemeriksaan' => 'datetime',
        'signed_at' => 'datetime',
        'waktu_input_hasil' => 'datetime',
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

    public function signedBy()
    {
        return $this->belongsTo(User::class, 'signed_by');
    }

    public function hasilDiinputOleh()
    {
        return $this->belongsTo(User::class, 'hasil_diinput_oleh');
    }

    public function parentRevision()
    {
        return $this->belongsTo(RadiologyOrder::class, 'parent_revision_id');
    }

    public function revisions()
    {
        return $this->hasMany(RadiologyOrder::class, 'parent_revision_id');
    }
}
