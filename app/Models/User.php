<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'nip',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@bps.go.id') && $this->hasVerifiedEmail();
    }

    /**
     * transaksi masuk
     *
     * @return void
     */
    public function transaksi_masuk()
    {
        return $this->hasMany(TransaksiMasuk::class);
    }

    /**
     * transaksi keluar
     *
     * @return void
     */
    public function transaksi_keluar()
    {
        return $this->hasMany(TransaksiKeluar::class);
    }

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
}
