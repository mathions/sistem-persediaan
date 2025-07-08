<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */

    protected $fillable = [
        'nama_status',
    ];

    /**
     * usulan
     *
     * @return void
     */
    public function usulan()
    {
        return $this->hasMany(Usulan::class);
    }

    /**
     * pemakaian
     *
     * @return void
     */
    public function pemakaian()
    {
        return $this->hasMany(Pemakaian::class);
    }

    /**
     * persetujuan
     *
     * @return void
     */
    public function persetujuan()
    {
        return $this->hasMany(Persetujuan::class);
    }
}
