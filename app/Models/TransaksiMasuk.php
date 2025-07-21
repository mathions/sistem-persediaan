<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Barang;

class TransaksiMasuk extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'referensi_id',
        'harga_beli',
        'volume',
        'total',
        'keterangan',
        'user_id',
    ];

    /**
     * referensi
     *
     * @return void
     */
    public function referensi()
    {
        return $this->belongsTo(Referensi::class);
    }

    /**
     * user
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($stock) {
            $stock->total = ((float) $stock->harga_beli) * ((float) $stock->volume);
        });
    }

    protected static function booted()
    {
        static::created(function ($transaksi) {
            $existing = \App\Models\Stok::where('referensi_id', $transaksi->referensi_id)->first();

            if ($existing) {
                // Update volume, harga_beli, dan total
                $existing->update([
                    'volume' => $existing->volume + $transaksi->volume,
                    'harga_beli' => $transaksi->harga_beli,
                    'total' => ($existing->volume + $transaksi->volume) * $transaksi->harga_beli,
                ]);
            } else {
                // Buat stok baru
                \App\Models\Stok::create([
                    'referensi_id' => $transaksi->referensi_id,
                    'harga_beli'   => $transaksi->harga_beli,
                    'volume'       => $transaksi->volume,
                    'total'        => $transaksi->harga_beli * $transaksi->volume,
                ]);
            }
        });
    }

}
