<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('pendaftars', function (Blueprint $table) {
        // Cek apakah kolom sudah ada sebelum menambahkan
        if (!Schema::hasColumn('pendaftars', 'user_id')) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
        }
    });
}

public function down()
{
    Schema::table('pendaftars', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn('user_id');
    });
}
};
