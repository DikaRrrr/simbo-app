<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->string('judul_laporan', 150);
            $table->unsignedBigInteger('id_kategori');
            $table->text('lokasi');
            $table->dateTime('tanggal_laporan')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('isi_laporan');
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->unsignedBigInteger('id_petugas')->nullable();
            $table->enum('status_laporan', ['Menunggu', 'Diproses', 'Selesai', 'Ditolak'])->default('Menunggu');
            $table->text('catatan_laporan')->nullable();
            $table->enum('prioritas_laporan', ['Rendah', 'Sedang', 'Tinggi'])->default('Sedang');
            $table->timestamps();

            $table->foreign('id_masyarakat')->references('id_masyarakat')->on('user_masyarakat')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_laporan')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_admin')->references('id_admin')->on('user_admin')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('id_petugas')->references('id_petugas')->on('user_petugas')->onDelete('set null')->onUpdate('cascade');
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