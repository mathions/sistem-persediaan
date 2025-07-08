<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persetujuan extends Model
{
    use HasFactory;
    
    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'pemakaian_id',
        'user_id',
        'status_id',
        'catatan'
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
     * status
     *
     * @return void
     */
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    /**
     * pemakaian
     *
     * @return void
     */
    public function pemakaian()
    {
        return $this->belongsTo(Pemakaian::class);
    }
}
