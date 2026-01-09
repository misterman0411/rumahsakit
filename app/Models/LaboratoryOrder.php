<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaboratoryOrder extends Model
{
    use HasFactory;

    protected $table = 'permintaan_laboratorium';

    protected $fillable = [
        'nomor_permintaan',
        'pasien_id',
        'dokter_id',
        'jenis_tes_id',
        'kunjungan_id',
        'status',
        'catatan',
        'sampel_diambil_oleh',
        'hasil_diinput_oleh',
        'waktu_input_hasil',
        'diverifikasi_oleh',
        'waktu_verifikasi',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->nomor_permintaan) {
                $order->nomor_permintaan = 'LAB-' . date('Ymd') . '-' . str_pad(
                    LaboratoryOrder::whereDate('created_at', today())->count() + 1,
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
        return $this->belongsTo(LabTestType::class, 'jenis_tes_id');
    }

    public function hasilLaboratorium()
    {
        return $this->hasOne(LaboratoryResult::class, 'permintaan_id');
    }

    public function tagihan()
    {
        return $this->morphOne(Invoice::class, 'tagihan_untuk', 'tagihan_untuk_tipe', 'tagihan_untuk_id');
    }

    public function sampelDiambilOleh()
    {
        return $this->belongsTo(User::class, 'sampel_diambil_oleh');
    }

    public function hasilDiinputOleh()
    {
        return $this->belongsTo(User::class, 'hasil_diinput_oleh');
    }

    public function diverifikasiOleh()
    {
        return $this->belongsTo(User::class, 'diverifikasi_oleh');
    }
}
