<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */

    protected $fillable = [
        'nama_barang',
        'satuan_id',
        'harga_beli',
        'stok',
    ];

    /**
     * transaksi masuk
     *
     * @return void
     */
    public function transaksi_masuk()
    {
        return $this->hasMany(TransaksiMasuk::class);
    }

    /**
     * transaksi keluar
     *
     * @return void
     */
    public function transaksi_keluar()
    {
        return $this->hasMany(TransaksiKeluar::class);
    }

    /**
     * detail_pemakaian
     *
     * @return void
     */
    public function detail_pemakaian()
    {
        return $this->hasMany(Transaksi::class);
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
}
