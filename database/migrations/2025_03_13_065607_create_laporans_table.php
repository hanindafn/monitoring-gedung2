v<?php

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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_gedung');
            $table->timestamp('tanggal_lapor')->useCurrent();
            $table->text('deskripsi_kerusakan');
            $table->string('tipe_kerusakan', 100);
            $table->enum('tingkat_kepentingan', ['urgent', 'tidak urgent']);
            $table->enum('status', ['menunggu', 'survei lapangan', 'ditugaskan', 'dalam antrean', 'diproses', 'selesai', 'ditolak'])->default('menunggu');
            $table->timestamps();
    
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_gedung')->references('id_gedung')->on('gedung')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};
