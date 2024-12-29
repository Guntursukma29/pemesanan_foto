<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('foto'); // Menyimpan path file foto
            $table->enum('tipe', ['videografi', 'fotografi']);
            $table->decimal('harga', 10, 2); // Harga dengan format desimal
            $table->string('waktu');
            $table->string('tenaga_kerja');
            $table->string('penyimpanan');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo');
    }
}
