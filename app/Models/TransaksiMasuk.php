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
        'barang_id',
        'satuan_id',
        'jumlah',
        'user_id'
    ];

    /**
     * barang
     *
     * @return void
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    /**
     * satuan
     *
     * @return void
     */
    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
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

    protected static function booted()
    {
        static::creating(function ($transaksi) {
            // Cek apakah ada barang dengan nama dan satuan yang sama
            $existing = Barang::where('nama_barang', $transaksi->barang->nama_barang)
                ->where('satuan_id', $transaksi->satuan_id)
                ->first();

            if ($existing) {
                // Tambahkan stok ke barang yang sudah ada
                $existing->increment('stok', $transaksi->jumlah);

                // Set barang_id transaksi ke ID barang yang sudah ada
                $transaksi->barang_id = $existing->id;
            } else {
                // Buat barang baru dengan stok awal dari transaksi
                $barangBaru = Barang::create([
                    'nama_barang' => $transaksi->barang->nama_barang,
                    'satuan_id'   => $transaksi->satuan_id,
                    'stok'        => $transaksi->jumlah,
                    'harga_beli'  => $transaksi->barang->harga_beli ?? 0, // default 0 kalau null
                ]);

                // Set barang_id transaksi ke barang baru
                $transaksi->barang_id = $barangBaru->id;
            }
        });
    }
}
