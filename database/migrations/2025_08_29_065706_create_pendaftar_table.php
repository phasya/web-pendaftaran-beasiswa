<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beasiswa_id')->constrained('beasiswa')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nim')->unique();
            $table->string('email');
            $table->string('no_hp');
            $table->text('alasan_mendaftar')->nullable();
            $table->string('file_transkrip')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_kk')->nullable();
            $table->enum('status', ['pending','diterima','ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftar');
    }
};
