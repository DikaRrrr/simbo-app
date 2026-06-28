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
        Schema::create('berita', function (Blueprint $table) {
            $table->id('id_berita');
            $table->unsignedBigInteger('id_petugas')->nullable();
            $table->unsignedBigInteger('id_admin_arsip')->nullable();
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->string('judul_berita', 150);
            $table->text('isi_berita');
            $table->string('gambar_berita')->nullable();
            $table->dateTime('tanggal_publish')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('tanggal_arsip')->nullable();
            $table->enum('status_arsip', ['aktif', 'diarsipkan'])->default('aktif');
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategori_laporan')->onDelete('set null');
            $table->foreign('id_petugas')->references('id_petugas')->on('user_petugas')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('id_admin_arsip')->references('id_admin')->on('user_admin')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
