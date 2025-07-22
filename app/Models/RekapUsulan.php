<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapUsulan extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */

    protected $fillable = [
        'referensi_id',
        'volume',
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

}
