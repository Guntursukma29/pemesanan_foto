<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan';

    protected $fillable = [
        'user_id',
        'pemesanan_id',
        'pemesanan_videografi_id',
        'pemesanan_promo_id',
        'foto',
        'bintang',
        'catatan',
        'status'
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke tabel pemesanan
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id');
    }

    // Relasi ke tabel pemesanan videografi
    public function pemesananVideografi()
    {
        return $this->belongsTo(PemesananVideografi::class, 'pemesanan_videografi_id');
    }

    // Relasi ke tabel pemesanan promo
    public function pemesananPromo()
    {
        return $this->belongsTo(PemesananPromo::class, 'pemesanan_promo_id');
    }
}
