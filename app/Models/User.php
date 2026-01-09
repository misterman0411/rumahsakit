<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method bool hasRole(string $roleName)
 * @method bool hasAnyRole(array $roles)
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'peran_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the role that owns the user.
     */
    public function peran()
    {
        return $this->belongsTo(Role::class, 'peran_id');
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole(string $roleName): bool
    {
        return $this->peran && $this->peran->nama === $roleName;
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->peran && in_array($this->peran->nama, $roles);
    }

    /**
     * Get the doctor associated with the user.
     */
    public function dokter()
    {
        return $this->hasOne(Doctor::class);
    }

    /**
     * Get the nurse associated with the user.
     */
    public function perawat()
    {
        return $this->hasOne(Nurse::class);
    }

    /**
     * Get lab results entered by this user (lab technician).
     */
    public function laboratoryResultsEntered()
    {
        return $this->hasMany(LaboratoryOrder::class, 'hasil_diinput_oleh');
    }

    /**
     * Get radiology reports signed by this user (radiologist).
     */
    public function radiologySignedReports()
    {
        return $this->hasMany(RadiologyOrder::class, 'signed_by');
    }
}
