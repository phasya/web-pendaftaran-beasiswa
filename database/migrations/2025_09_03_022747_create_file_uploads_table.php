<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('file_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained('pendaftars')->onDelete('cascade');
            $table->foreignId('file_type_id')->constrained('file_types')->onDelete('cascade');
            $table->string('nama_file_asli'); // Nama file asli yang diupload
            $table->string('nama_file_sistem'); // Nama file yang disimpan di sistem
            $table->string('path_file'); // Path lengkap file
            $table->string('ekstensi');
            $table->integer('ukuran'); // dalam bytes
            $table->enum('status_verifikasi', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan_verifikasi')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->unique(['pendaftar_id', 'file_type_id']); // Satu pendaftar hanya bisa upload satu file per type
        });
    }

    public function down()
    {
        Schema::dropIfExists('file_uploads');
    }
};