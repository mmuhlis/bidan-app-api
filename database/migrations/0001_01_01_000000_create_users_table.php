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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // identitas pengguna
            $table->string('email')->unique();
            $table->string('password');

            // identitas pribadi
            $table->date('nomor_registrasi_ibu');
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Tambahkan indeks untuk performa pencarian
            $table->index('nik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
