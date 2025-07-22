<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referensi extends Model
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
    ];

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
     * stok
     *
     * @return void
     */
    public function stok()
    {
        return $this->hasMany(Stok::class);
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
     * detail pemakaian
     *
     * @return void
     */
    public function detail_pemakaian()
    {
        return $this->hasMany(DetailPemakaian::class);
    }

    /**
     * rekap usulan
     *
     * @return void
     */
    public function rekap_usulan()
    {
        return $this->hasMany(RekapUsulan::class);
    }
}
