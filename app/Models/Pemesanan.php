<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';

    protected $fillable = [
        'id_user',
        'id_fotografer',
        'id_paket',
        'tanggal',
        'jam',
        'alamat',
        'catatan',
        'tempat',
        'status_pemesanan',
        'status_pembayaran',
        'order_id',
        'paket_jenis',
        'link_dokumentasi',
        'code_foto',
        'link_foto'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi ke Paket
    public function paket()
    {
        return $this->belongsTo(Fotografi::class, 'id_paket');
    }
    // App\Models\Pemesanan.php
    public function fotografer()
    {
        return $this->belongsTo(User::class, 'id_fotografer');
    }
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'pemesanan_id');
    }
    public function fotografi()
    {
        return $this->belongsTo(Fotografi::class, 'id_paket'); // Pastikan foreign key sesuai
    }


}
