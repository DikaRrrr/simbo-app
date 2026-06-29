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
        Schema::create('user_masyarakat', function (Blueprint $table) {
            $table->id('id_masyarakat');
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap');
            $table->string('no_hp');
            $table->string('email')->unique();
            $table->string('password');
            $table->text('alamat');
            $table->string('foto_profile')->nullable();
            $table->enum('status_akun', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_masyarakat');
    }
};
