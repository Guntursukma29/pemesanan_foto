<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'foto'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }
    public function fotografer()
    {
        return $this->hasOne(Fotografer::class);
    }
    public function pemesanan()
    {
        return $this->hasMany(Pemesanan::class,'id_fotografer');
    }
    public function hasRole($role)
    {
        return $this->role == $role; // Misalnya, atribut `role` ada di tabel `users`
    }
    public function pemesananVideografi()
    {
        return $this->hasMany(PemesananVideografi::class,'id_fotografer');
    }
    public function fotograf()
    {
        return $this->belongsTo(User::class, 'id_fotografer');
    }
    public function pemesananPromo()
    {
        return $this->hasMany(PemesananPromo::class,'id_fotografer');
    }
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'user_id');
    }

}
