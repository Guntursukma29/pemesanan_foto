<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fotografi extends Model
{
    use HasFactory;

    protected $table = 'fotografi';

    protected $fillable = [
        'nama',
        'foto',
        'harga_special',
        'harga_platinum',
        'tenaga_kerja_spesial',
        'tenaga_kerja_platinum',
        'waktu_spesial',
        'waktu_platinum',
        'penyimpanan_special',
        'penyimpanan_platinum',
        'deskripsi',
    ];
    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'id_paket');
    }

}
