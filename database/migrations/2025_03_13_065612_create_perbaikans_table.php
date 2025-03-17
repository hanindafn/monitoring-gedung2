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
        Schema::create('perbaikan', function (Blueprint $table) {
            $table->id('id_perbaikan');
            $table->unsignedBigInteger('id_laporan');
            $table->unsignedBigInteger('id_teknisi')->nullable();
            $table->dateTime('tanggal_mulai')->nullable();
            $table->dateTime('tanggal_selesai')->nullable();
            $table->text('deskripsi_perbaikan')->nullable();
            $table->enum('status', ['survei lapangan','ditugaskan', 'diproses', 'selesai', 'ditolak'])->default('survei lapangan');
            $table->timestamps();

            $table->foreign('id_laporan')->references('id_laporan')->on('laporan')->onDelete('cascade');
            $table->foreign('id_teknisi')->references('id_teknisi')->on('teknisi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perbaikan');
    }
};
