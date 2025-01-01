<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videografi extends Model
{
    use HasFactory;

    // The table associated with the model
    protected $table = 'videografi';

    // The attributes that are mass assignable
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
        'deskripsi_spesial',
        'deskripsi_platinum'    ];
   
    public function pemesanans()
    {
        return $this->hasMany(PemesananVideografi::class, 'id_paket');
    }

}
