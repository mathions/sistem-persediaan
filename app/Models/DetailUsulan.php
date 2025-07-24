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
        'referensi_id',
        'volume',
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
     * referensi
     *
     * @return void
     */
    public function referensi()
    {
        return $this->belongsTo(Referensi::class);
    }

}
