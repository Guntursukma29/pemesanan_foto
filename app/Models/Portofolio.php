<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory;

    // Tentukan nama tabel (optional jika nama tabel sudah sesuai dengan konvensi)
    protected $table = 'portofolio';

    // Tentukan kolom yang dapat diisi (fillable) untuk mencegah mass assignment
    protected $fillable = ['foto'];

    // Jika kamu ingin menambahkan hubungan dengan model lain, bisa ditambahkan di sini
}
