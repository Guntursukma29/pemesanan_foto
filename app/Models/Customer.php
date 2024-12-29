<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda dari nama model (Laravel secara otomatis mengasumsikan tabel bernama 'customers')
    protected $table = 'customers';

    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'user_id', // relasi ke tabel users
        'nomor_telepon', // nomor telepon yang diisi saat registrasi
    ];

    /**
     * Mendefinisikan relasi ke model User.
     * Setiap customer berhubungan dengan satu user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
