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

    /**
     * Resolved image URL for templates.
     *
     * - On Vercel, image_path stores the full Vercel Blob URL (returned by
     *   the custom storage adapter after upload), so we use it verbatim.
     * - On local/XAMPP, image_path is a relative path under
     *   storage/app/public and we resolve it via the `public` disk.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        if (preg_match('#^https?://#i', $this->image_path)) {
            return $this->image_path;
        }

        try {
            return \Illuminate\Support\Facades\Storage::disk('public')->url($this->image_path);
        } catch (\Throwable) {
            return asset('storage/'.$this->image_path);
        }
    }

    /**
     * Display label for the stored image path (used in the print view).
     */
    public function getImagePathLabelAttribute(): string
    {
        if (! $this->image_path) {
            return '-';
        }

        // Strip the Vercel Blob host so the printed label shows just the key.
        return preg_replace('#^https?://[^/]+/#', '', $this->image_path) ?? $this->image_path;
    }

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
