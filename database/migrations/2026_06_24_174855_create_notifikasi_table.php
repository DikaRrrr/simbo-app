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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id('id_notifikasi');
            $table->unsignedBigInteger('id_laporan')->nullable();
            $table->unsignedBigInteger('id_masyarakat')->nullable();
            $table->string('isi_notifikasi');
            $table->boolean('status_baca')->default(false); // 0 = Belum dibaca, 1 = Sudah
            $table->timestamps();
            $table->foreign('id_laporan')->references('id_laporan')->on('laporan')->onDelete('cascade');
            $table->foreign('id_masyarakat')->references('id_masyarakat')->on('user_masyarakat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
