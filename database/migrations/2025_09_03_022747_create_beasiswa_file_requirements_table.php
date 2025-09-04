<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('beasiswa_file_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beasiswa_id')->constrained('beasiswas')->onDelete('cascade');
            $table->foreignId('file_type_id')->constrained('file_types')->onDelete('cascade');
            $table->boolean('wajib')->default(true); // Override dari file_type, bisa berbeda per beasiswa
            $table->text('catatan')->nullable(); // Catatan khusus untuk file di beasiswa ini
            $table->timestamps();

            $table->unique(['beasiswa_id', 'file_type_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('beasiswa_file_requirements');
    }
};