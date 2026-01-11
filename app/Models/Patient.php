<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'user_id',
        'no_rekam_medis',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'status_pernikahan',
        'kewarganegaraan',
        'pekerjaan',
        'tempat_lahir',
        'telepon',
        'email',
        'alamat',
        'golongan_darah',
        'alergi',
        'nama_kontak_darurat',
        'telepon_kontak_darurat',
        'jenis_asuransi',
        'nomor_asuransi',
        'status',
    ];

    /**
     * Get the user account associated with the patient.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function janjiTemu()
    {
        return $this->hasMany(Appointment::class, 'pasien_id');
    }

    public function rekamMedis()
    {
        return $this->hasMany(MedicalRecord::class, 'pasien_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class, 'pasien_id');
    }

    // Alias Indonesia
    public function resep()
    {
        return $this->prescriptions();
    }

    public function laboratoryOrders()
    {
        return $this->hasMany(LaboratoryOrder::class, 'pasien_id');
    }

    // Alias Indonesia
    public function permintaanLaboratorium()
    {
        return $this->laboratoryOrders();
    }

    public function radiologyOrders()
    {
        return $this->hasMany(RadiologyOrder::class, 'pasien_id');
    }

    // Alias Indonesia
    public function permintaanRadiologi()
    {
        return $this->radiologyOrders();
    }

    public function vitalSigns()
    {
        return $this->hasMany(VitalSign::class, 'pasien_id');
    }

    public function inpatientAdmissions()
    {
        return $this->hasMany(InpatientAdmission::class, 'pasien_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'pasien_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'pasien_id');
    }

    // Accessor for full name
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    // Accessor for age
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }
}
