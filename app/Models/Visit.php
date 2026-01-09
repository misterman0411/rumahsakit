<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';

    protected $fillable = [
        'pasien_id',
        'tanggal_kunjungan',
        'jenis_kunjungan',
        'status',
        'keluhan_utama',
        'catatan',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'datetime',
    ];

    // Relationships
    public function pasien()
    {
        return $this->belongsTo(Patient::class, 'pasien_id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'kunjungan_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'kunjungan_id');
    }

    public function laboratoryOrders()
    {
        return $this->hasMany(LaboratoryOrder::class, 'kunjungan_id');
    }

    public function radiologyOrders()
    {
        return $this->hasMany(RadiologyOrder::class, 'kunjungan_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'kunjungan_id');
    }

    public function inpatientAdmissions()
    {
        return $this->hasMany(InpatientAdmission::class, 'kunjungan_id');
    }

    // Helper method to get the main invoice for this visit
    public function getMainInvoice()
    {
        return $this->invoices()->first();
    }

    // Helper method to check if visit is active
    public function isActive()
    {
        return in_array($this->status, ['aktif', 'dalam_perawatan']);
    }
}
