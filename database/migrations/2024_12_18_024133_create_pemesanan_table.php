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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_paket')->constrained('fotografi')->onDelete('cascade'); // Relasi ke paket
            $table->date('tanggal');
            $table->time('jam');
            $table->string('alamat');
            $table->text('catatan')->nullable();
            $table->enum('tempat', ['Indoor', 'Outdoor']);
            $table->enum('paket_jenis', ['special', 'platinum']); 
            $table->enum('status_pemesanan', ['pending', 'proses', 'dokumentasi', 'selesai', 'batal'])->default('pending');
            $table->enum('status_pembayaran', ['belum bayar', 'dibayar','gagal'])->default('belum bayar');
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
        Schema::dropIfExists('pemesanan');
    }
};
