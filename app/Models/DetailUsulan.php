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
        'nama_barang',
        'satuan_id',
        'jumlah',
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
     * satuan
     *
     * @return void
     */
    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
}
