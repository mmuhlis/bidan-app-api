<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\SkriningKehamilan;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'nik',
        'email',
        'password',
        'nama_lengkap',
        'alamat',
        'no_hp',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi dengan rekam medis.
     */
    public function rekamMedis()
    {
        return $this->hasMany(RekamMedis::class, 'nik', 'nik'); // Hubungkan berdasarkan NIK
    }
    public function SkriningKehamilan()
    {
        return $this->hasMany(SkriningKehamilan::class, 'user_id');
    }
}
