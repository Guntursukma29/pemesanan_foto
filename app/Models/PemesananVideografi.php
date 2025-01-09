<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananVideografi extends Model
{
    use HasFactory;

    protected $table = 'pemesananvideografi'; // Menentukan nama tabel yang digunakan
    protected $fillable = [
        'order_id', 'id_fotografer', 'id_user', 'id_paket', 'tanggal', 'jam', 'alamat', 'catatan', 'tempat', 'paket_jenis', 'status_pemesanan', 'status_pembayaran','link_dokumentasi','code_foto','link_foto'
    ];

    /**
     * Relasi dengan tabel User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relasi dengan tabel Videografi
     */
    public function paket()
    {
        return $this->belongsTo(Videografi::class, 'id_paket');
    }
    public function fotografer()
    {
        return $this->belongsTo(User::class, 'id_fotografer');
    }
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'pemesanan_videografi_id');
    }
        public function videografi()
    {
        return $this->belongsTo(Videografi::class, 'id_paket');
    }
}
