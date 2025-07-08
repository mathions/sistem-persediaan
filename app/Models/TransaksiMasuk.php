<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
