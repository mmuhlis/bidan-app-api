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
        Schema::create('skrining_kehamilans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Data pengkajian & bidan
            $table->date('tanggal_pengkajian');
            $table->string('bidan_pelaksana');

            // Data ibu hamil
            $table->string('nama_ibu');
            $table->integer('umur_ibu');
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->integer('hamil_ke');
            $table->date('hpht');
            $table->date('hpl');
            $table->string('umur_kehamilan');
            $table->string('tempat_periksa');

            // Data hasil skrining
            $table->json('jawaban_skrining'); // berisi array pertanyaan + ya/tidak
            $table->integer('total_skor');
            $table->string('kategori_risiko'); // KRR, KRT, KRST

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skrining_kehamilans');
    }
};
