<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('videografi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('foto')->nullable(); // Menyimpan path foto
            $table->decimal('harga_special', 10, 2);
            $table->decimal('harga_platinum', 10, 2);
            $table->integer('tenaga_kerja_spesial');   // Jumlah tenaga kerja
            $table->integer('tenaga_kerja_platinum');   // Jumlah tenaga kerja
            $table->integer('waktu_spesial');          // Waktu dalam jam
            $table->integer('waktu_platinum');          // Waktu dalam jam
            $table->string('penyimpanan_special');     // Penyimpanan, misalnya USB atau Cloud
            $table->string('penyimpanan_platinum');     // Penyimpanan, misalnya USB atau Cloud
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videografi');
    }
};
