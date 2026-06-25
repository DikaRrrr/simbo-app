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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->unsignedBigInteger('id_masyarakat');
            $table->unsignedBigInteger('id_kategori');
            $table->unsignedBigInteger('id_petugas')->nullable(); 
        
            $table->string('judul_laporan');
            $table->text('isi_laporan'); // Ini untuk 'Deskripsi Detail' di UI
            $table->string('lokasi'); // Sesuai kolom di ERD
            $table->date('tanggal_laporan');
            $table->enum('status_laporan', ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])->default('Menunggu');
            $table->timestamps();

        // Foreign Key Constraints
            $table->foreign('id_masyarakat')->references('id_masyarakat')->on('user_masyarakat')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_laporan')->onDelete('restrict');
            $table->foreign('id_petugas')->references('id_petugas')->on('user_petugas')->onDelete('set null');
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
