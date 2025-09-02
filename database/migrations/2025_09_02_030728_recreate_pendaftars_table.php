<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Drop existing table if exists
        Schema::dropIfExists('pendaftars');
        
        // Create new complete table
        Schema::create('pendaftars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beasiswa_id')->constrained('beasiswas')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nim', 20)->unique();
            $table->string('email')->unique();
            $table->string('no_hp', 15);
            $table->text('alasan_mendaftar');
            $table->string('file_transkrip')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_kk')->nullable();
            $table->enum('status', ['pending', 'diterima', 'ditolak', 'dibatalkan'])->default('pending');
            $table->timestamp('tanggal_daftar')->useCurrent();
            $table->text('keterangan')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->string('verified_by')->nullable();
            $table->unsignedBigInteger('verified_by_id')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['beasiswa_id', 'status']);
            $table->index('tanggal_daftar');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftars');
    }
};