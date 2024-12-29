<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemesananPromo extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'pemesananpromo';

    // Fillable fields
    protected $fillable = [
        'order_id',
        'id_user',
        'id_paket',
        'id_fotografer',
        'tanggal',
        'jam',
        'alamat',
        'catatan',
        'tempat',
        'status_pemesanan',
        'status_pembayaran',
        'link_dokumentasi',
        'code_foto',
        'link_foto'
    ];

    /**
     * Relationship with the User model (id_user)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relationship with the Promo model (id_paket)
     */
    public function promo()
    {
        return $this->belongsTo(Promo::class, 'id_paket');
    }

    /**
     * Relationship with the User model for Fotografer (id_fotografer)
     */
    public function fotografer()
    {
        return $this->belongsTo(User::class, 'id_fotografer');
    }
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'pemesanan_promo_id');
    }
    public function pemesananpromo()
    {
        return $this->belongsTo(Promo::class, 'promo_id');
    }

    /**
     * Accessor for status_pemesanan
     */
    
}
