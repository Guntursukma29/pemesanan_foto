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
            $table->string('harga_special', 10, 2)->nullable();
            $table->string('harga_platinum', 10, 2)->nullable();
            $table->string('tenaga_kerja_spesial')->nullable();   // Jumlah tenaga kerja
            $table->string('tenaga_kerja_platinum')->nullable();   // Jumlah tenaga kerja
            $table->string('waktu_spesial')->nullable();          // Waktu dalam jam
            $table->string('waktu_platinum')->nullable();          // Waktu dalam jam
            $table->string('penyimpanan_special')->nullable();     // Penyimpanan, misalnya USB atau Cloud
            $table->string('penyimpanan_platinum')->nullable();     // Penyimpanan, misalnya USB atau Cloud
            $table->text('deskripsi_spesial')->nullable();
            $table->text('deskripsi_platinum')->nullable();            
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
