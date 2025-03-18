<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'admin_id',
        'umur',
        'kategori',
        'alamat',
        'keluhan',
        'diagnosa',
        'tindakan',
        'tanggal_periksa',
    ];

    /**
     * Relasi ke user berdasarkan NIK.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'nik', 'nik');
    }

    /**
     * Relasi ke admin (bidan).
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
