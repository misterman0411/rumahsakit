<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nurse extends Model
{
    use HasFactory;

    protected $table = 'perawat';

    protected $fillable = [
        'user_id',
        'departemen_id',
        'nomor_izin_praktik',
        'telepon',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Department::class, 'departemen_id');
    }
}
