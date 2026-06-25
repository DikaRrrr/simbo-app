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
        Schema::create('berita', function (Blueprint $table) {
            $table->id('id_berita');
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->unsignedBigInteger('id_petugas')->nullable();
        
            $table->string('judul_berita');
            $table->text('isi_berita');
            $table->date('tanggal_publish');
            $table->boolean('status_arsip')->default(false);
            $table->timestamps();

            $table->foreign('id_admin')->references('id_admin')->on('user_admin')->onDelete('set null');
            $table->foreign('id_petugas')->references('id_petugas')->on('user_petugas')->onDelete('set null');
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
