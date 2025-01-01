<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $table = 'promo';

    protected $fillable = [
        'nama',
        'foto',
        'tipe',
        'harga',
        'waktu',
        'tenaga_kerja',
        'penyimpanan',
        'deskripsi',
        'mulai',
        'berakhir'
    ];
    public function pemesanans()
    {
        return $this->hasMany(PemesananPromo::class, 'id_paket');
    }
}
