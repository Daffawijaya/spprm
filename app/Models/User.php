<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN   = 'admin';
    public const ROLE_TERAPIS = 'terapis';
    public const ROLE_DOKTER  = 'dokter';
    public const ROLE_PASIEN  = 'pasien';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'pasien_id',
    ];

    protected $hidden = [
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
