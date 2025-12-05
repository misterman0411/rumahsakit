<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class StockMovement extends Model
{
    use HasFactory;

    protected $table = 'mutasi_stok';

    protected $fillable = [
        'obat_id',
        'jenis_mutasi',
        'jumlah',
        'stok_sebelum',
        'stok_sesudah',
        'referensi',
        'keterangan',
        'user_id',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'stok_sebelum' => 'integer',
        'stok_sesudah' => 'integer',
    ];

    public function obat()
    {
        return $this->belongsTo(Medication::class, 'obat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function referensi()
    {
        return $this->morphTo();
    }

    // Helper method to record stock movement
    public static function recordMovement(Medication $medication, $jenis_mutasi, $jumlah, $referenceType = null, $referenceId = null, $keterangan = null)
    {
        $stockBefore = $medication->stok;
        
        if ($jenis_mutasi === 'in' || $jenis_mutasi === 'adjustment') {
            $stockAfter = $stockBefore + abs($jumlah);
        } else {
            $stockAfter = $stockBefore - abs($jumlah);
        }

        // Update medication stock
        $medication->update(['stok' => $stockAfter]);

        // Record movement
        $movement = self::create([
            'obat_id' => $medication->id,
            'jenis_mutasi' => $jenis_mutasi,
            'jumlah' => $jumlah,
            'stok_sebelum' => $stockBefore,
            'stok_sesudah' => $stockAfter,
            'keterangan' => $keterangan,
            'user_id' => Auth::id(),
        ]);

        return $movement;
    }
}
