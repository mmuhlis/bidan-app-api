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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->string('nik'); // Gunakan NIK sebagai referensi pasien
            $table->unsignedBigInteger('admin_id'); // ID Bidan/Admin
            $table->integer('umur');
            $table->enum('kategori', ['IBU HAMIL', 'BALITA']);
            $table->string('alamat');
            $table->text('keluhan');
            $table->text('diagnosa');
            $table->text('tindakan');
            $table->date('tanggal_periksa');
            $table->timestamps();

            // Foreign key untuk user berdasarkan NIK
            $table->foreign('nik')->references('nik')->on('users')->onDelete('cascade');

            // Foreign key untuk admin (bidan)
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');

            // indeks untuk  pencarian
            $table->index('nik');
            $table->index('admin_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
