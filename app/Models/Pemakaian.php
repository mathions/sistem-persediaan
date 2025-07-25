<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Persetujuan;

class Pemakaian extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'nama_pemakaian',
        'status_id'
    ];

    /**
     * users
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * detailpemakaians
     *
     * @return void
     */
    public function detail_pemakaian()
    {
        return $this->hasMany(DetailPemakaian::class);
    }

    /**
     * status
     *
     * @return void
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

}
