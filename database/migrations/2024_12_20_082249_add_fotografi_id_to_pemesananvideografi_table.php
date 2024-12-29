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
        Schema::table('pemesananvideografi', function (Blueprint $table) {
            $table->unsignedBigInteger('id_fotografer')->nullable()->after('id_user');
            $table->foreign('id_fotografer')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesananvideografi', function (Blueprint $table) {
            $table->dropForeign(['id_fotografer']);
            $table->dropColumn('id_fotografer');
        });
    }
};
