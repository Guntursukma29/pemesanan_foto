<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUlasanTable extends Migration
{
    public function up()
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relasi ke tabel users
            $table->unsignedBigInteger('pemesanan_id')->nullable(); // Relasi ke tabel pemesanan
            $table->unsignedBigInteger('pemesanan_videografi_id')->nullable(); // Relasi ke tabel pemesanan videografi
            $table->unsignedBigInteger('pemesanan_promo_id')->nullable(); // Relasi ke tabel pemesanan promo
            $table->string('foto')->nullable(); // Kolom untuk foto
            $table->tinyInteger('bintang')->unsigned(); // Kolom untuk rating bintang
            $table->text('catatan')->nullable(); // Kolom untuk catatan
            $table->enum('status', ['tampilkan', 'sembunyikan'])->default('tampilkan');

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pemesanan_id')->references('id')->on('pemesanan')->onDelete('cascade');
            $table->foreign('pemesanan_videografi_id')->references('id')->on('pemesananvideografi')->onDelete('cascade');
            $table->foreign('pemesanan_promo_id')->references('id')->on('pemesananpromo')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ulasan');
    }
}

