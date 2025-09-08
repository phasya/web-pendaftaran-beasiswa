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
        Schema::create('pendaftar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beasiswa_id')->constrained('beasiswas')->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nim', 20)->unique();
            $table->string('email');
            $table->string('no_hp', 15);
            $table->text('alasan_mendaftar');
            $table->string('file_transkrip')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_kk')->nullable();
            $table->enum('status', ['pending', 'diterima', 'ditolak', 'dibatalkan'])->default('pending');
            $table->timestamp('tanggal_daftar')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['beasiswa_id', 'status']);
            $table->index(['nim', 'email']);
            $table->index('tanggal_daftar');
            $table->index('status');
            
            // Unique constraint untuk kombinasi beasiswa_id dan nim
            $table->unique(['beasiswa_id', 'nim'], 'unique_beasiswa_nim');
            $table->unique(['beasiswa_id', 'email'], 'unique_beasiswa_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar');
    }
};