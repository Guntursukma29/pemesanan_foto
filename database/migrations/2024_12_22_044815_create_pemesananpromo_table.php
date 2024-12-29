<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pemesananpromo', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); // Relasi ke tabel users
            $table->foreignId('id_paket')->constrained('promo')->onDelete('cascade'); // Relasi ke tabel promo
            $table->foreignId('id_fotografer')->nullable()->constrained('users')->onDelete('cascade'); // Relasi ke users dengan role fotografer, nullable
            $table->date('tanggal');
            $table->time('jam');
            $table->string('alamat');
            $table->text('catatan')->nullable();
            $table->enum('tempat', ['Indoor', 'Outdoor']);
            $table->enum('status_pemesanan', ['pending', 'proses', 'dokumentasi', 'selesai', 'batal'])->default('pending');
            $table->enum('status_pembayaran', ['belum bayar', 'dibayar', 'gagal'])->default('belum bayar');
            $table->string('link_dokumentasi')->nullable();
            $table->text('code_foto')->nullable();
            $table->text('link_foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesananpromo');
    }
};
