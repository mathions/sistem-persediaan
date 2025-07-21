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
        'referensi_id',
        'volume',
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
     * referensi
     *
     * @return void
     */
    public function referensi()
    {
        return $this->belongsTo(Referensi::class);
    }

}
