<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkriningKehamilan extends Model
{
    /** @use HasFactory<\Database\Factories\SkriningKehamilanFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal_pengkajian',
        'bidan_pelaksana',
        'nama_ibu',
        'umur_ibu',
        'alamat',
        'no_hp',
        'pendidikan',
        'pekerjaan',
        'hamil_ke',
        'hpht',
        'hpl',
        'umur_kehamilan',
        'tempat_periksa',

        // Data hasil skrining
        'jawaban_skrining', // berisi array pertanyaan + ya/tidak
        'total_skor',
        'kategori_risiko', // KRR, KRT, KRST
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
