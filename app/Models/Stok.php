<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
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
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($stock) {
            $stock->total = ((float) $stock->harga_beli) * ((float) $stock->volume);
        });
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

}
