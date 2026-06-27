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
        Schema::create('user_petugas', function (Blueprint $table) {
            $table->id('id_petugas');
            $table->string('nama_petugas');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('wilayah_tugas');
            $table->enum('status_akun', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_petugas');
    }
};
