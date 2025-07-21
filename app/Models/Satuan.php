<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */

    protected $fillable = [
        'nama_satuan',
    ];

    /**
     * barang
     *
     * @return void
     */
    public function barang()
    {
        return $this->hasMany(Barang::class);
    }

    /**
     * referensi
     *
     * @return void
     */
    public function referensi()
    {
        return $this->hasMany(Referensi::class);
    }

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
     * detail usulan
     *
     * @return void
     */
    public function detail_usulan()
    {
        return $this->hasMany(DetailUsulan::class);
    }

    /**
     * detail usulan
     *
     * @return void
     */
    public function detail_pemakaian()
    {
        return $this->hasMany(DetailPemakaian::class);
    }
}
