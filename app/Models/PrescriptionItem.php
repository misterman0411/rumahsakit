<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionItem extends Model
{
    use HasFactory;

    protected $table = 'item_resep';

    protected $fillable = [
        'resep_id',
        'obat_id',
        'jumlah',
        'dosis',
        'frekuensi',
        'durasi',
        'instruksi',
    ];

    protected $casts = [
        'jumlah' => 'integer',
    ];

    public function resep()
    {
        return $this->belongsTo(Prescription::class, 'resep_id');
    }

    public function obat()
    {
        return $this->belongsTo(Medication::class, 'obat_id');
    }
}
