<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InpatientAdmission extends Model
{
    use HasFactory;

    protected $table = 'rawat_inap';

    protected $fillable = [
        'nomor_rawat_inap',
        'pasien_id',
        'dokter_id',
        'ruangan_id',
        'tempat_tidur_id',
        'tanggal_masuk',
        'tanggal_keluar',
        'jenis_masuk',
        'alasan_masuk',
        'status',
        'resume_keluar',
        'instruksi_pulang',
        'tanggal_kontrol',
        'status_pulang',
        'diskon',
        'pajak',
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_keluar' => 'datetime',
        'tanggal_kontrol' => 'date',
        'diskon' => 'decimal:2',
        'pajak' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($admission) {
            if (!$admission->nomor_rawat_inap) {
                $admission->nomor_rawat_inap = 'RI-' . date('Ymd') . '-' . str_pad(
                    InpatientAdmission::whereDate('created_at', today())->count() + 1,
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

    public function ruangan()
    {
        return $this->belongsTo(Room::class, 'ruangan_id');
    }

    public function tempatTidur()
    {
        return $this->belongsTo(Bed::class, 'tempat_tidur_id');
    }

    public function biayaRawatInap()
    {
        return $this->hasMany(InpatientCharge::class, 'rawat_inap_id');
    }

    public function catatanHarian()
    {
        return $this->hasMany(InpatientDailyLog::class, 'rawat_inap_id');
    }

    public function tandaVital()
    {
        return $this->hasMany(VitalSign::class, 'rawat_inap_id');
    }

    public function tagihan()
    {
        return $this->morphOne(Invoice::class, 'tagihan_untuk', 'tagihan_untuk_tipe', 'tagihan_untuk_id');
    }

    public function calculateTotalCost()
    {
        // Calculate from daily charges instead of just room rate
        $chargesTotal = $this->biayaRawatInap()->sum('total');
        
        // If no charges recorded, fallback to old calculation
        if ($chargesTotal == 0 && $this->tanggal_keluar) {
            $days = $this->tanggal_masuk->diffInDays($this->tanggal_keluar);
            if ($days < 1) {
                $days = 1;
            }
            $chargesTotal = $this->ruangan->tarif_per_hari * $days;
        }

        $subtotal = $chargesTotal;
        $total = $subtotal - $this->diskon + $this->pajak;

        return $total;
    }

    public function getLengthOfStayAttribute()
    {
        $endDate = $this->tanggal_keluar ?? now();
        return $this->tanggal_masuk->diffInDays($endDate) + 1; // Include first day
    }
}
