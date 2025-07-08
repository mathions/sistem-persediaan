<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPemakaian extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */

    protected $fillable = [
        'pemakaian_id',
        'barang_id',
        'satuan_id',
        'jumlah',
    ];

    /**
     * pemakaians
     *
     * @return void
     */
    public function pemakaian()
    {
        return $this->belongsTo(Pemakaian::class);
    }

    /**
     * barangs
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
}
