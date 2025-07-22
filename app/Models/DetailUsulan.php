<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailUsulan extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */

    protected $fillable = [
        'usulan_id',
        'referensi_id',
        'volume',
    ];

    /**
     * usulans
     *
     * @return void
     */
    public function usulan()
    {
        return $this->belongsTo(Usulan::class);
    }

    /**
     * referensi
     *
     * @return void
     */
    public function referensi()
    {
        return $this->belongsTo(Referensi::class);
    }

    protected static function booted()
    {
        static::created(function ($detailUsulan) {
            $rekap = \App\Models\RekapUsulan::where('referensi_id', $detailUsulan->referensi_id)->first();

            if ($rekap) {
                // Jika sudah ada, tambahkan volume
                $rekap->update([
                    'volume' => $rekap->volume + $detailUsulan->volume,
                ]);
            } else {
                // Jika belum ada, buat baru
                \App\Models\RekapUsulan::create([
                    'referensi_id' => $detailUsulan->referensi_id,
                    'volume' => $detailUsulan->volume,
                ]);
            }
        });
    }
}
