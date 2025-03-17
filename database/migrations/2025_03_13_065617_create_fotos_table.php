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
        Schema::create('foto', function (Blueprint $table) {
            $table->id('id_foto');
            $table->unsignedBigInteger('id_laporan')->nullable();
            $table->unsignedBigInteger('id_perbaikan')->nullable();
            $table->unsignedBigInteger('id_gedung')->nullable();
            $table->string('url_foto', 255);
            $table->timestamps();
    
            $table->foreign('id_laporan')->references('id_laporan')->on('laporan')->onDelete('cascade');
            $table->foreign('id_perbaikan')->references('id_perbaikan')->on('perbaikan')->onDelete('cascade');
            $table->foreign('id_gedung')->references('id_gedung')->on('gedung')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto');
    }
};
