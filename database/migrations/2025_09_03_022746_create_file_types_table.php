<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('file_types', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file_type'); // Contoh: KTP, Transkrip Nilai, Surat Keterangan Tidak Mampu
            $table->text('deskripsi')->nullable();
            $table->string('ekstensi_diizinkan')->default('pdf,jpg,jpeg,png'); // Format yang diizinkan
            $table->integer('ukuran_maksimal')->default(2048); // dalam KB
            $table->boolean('wajib')->default(true); // Apakah file ini wajib diupload
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0); // Untuk mengurutkan tampilan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('file_types');
    }
};