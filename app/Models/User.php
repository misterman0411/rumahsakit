<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method bool hasRole(string $roleName)
 * @method bool hasAnyRole(array $roles)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'password',
        'peran_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi role / peran
     */
    public function peran()
    {
        return $this->belongsTo(Role::class, 'peran_id');
    }

    /**
     * Cek role spesifik
     */
    public function hasRole(string $roleName): bool
    {
        return $this->peran && $this->peran->nama === $roleName;
    }

    /**
     * Cek salah satu dari banyak role
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->peran && in_array($this->peran->nama, $roles);
    }

    /**
     * Relasi staf medis
     */
    public function dokter()
    {
        return $this->hasOne(Doctor::class);
    }

    public function perawat()
    {
        return $this->hasOne(Nurse::class);
    }

    /**
     * Relasi pasien
     */
    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    /**
     * Cek apakah user adalah pasien (non-staff)
     */
    public function isPatient(): bool
    {
        $staffRoles = [
            'admin',
            'doctor',
            'nurse',
            'front_office',
            'pharmacist',
            'lab_technician',
            'radiologist',
            'cashier',
            'management',
        ];

        return !$this->hasAnyRole($staffRoles);
    }

    /**
     * Relasi hasil lab (oleh petugas lab)
     */
    public function laboratoryResultsEntered()
    {
        return $this->hasMany(LaboratoryOrder::class, 'hasil_diinput_oleh');
    }

    /**
     * Relasi laporan radiologi (oleh radiolog)
     */
    public function radiologySignedReports()
    {
        return $this->hasMany(RadiologyOrder::class, 'signed_by');
    }
}
