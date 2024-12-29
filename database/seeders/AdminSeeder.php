<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Membuat user admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',  // Ganti dengan email admin Anda
            'password' => Hash::make('password123'),  // Ganti dengan password yang lebih aman
            'role' => 'admin',  // Menetapkan role admin
        ]);
    }
}
