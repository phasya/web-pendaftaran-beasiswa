<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('beasiswas', function (Blueprint $table) {
            if (!Schema::hasColumn('beasiswas', 'dokumen_pendukung')) {
                $table->json('dokumen_pendukung')->nullable()->after('persyaratan');
            }
        });
    }

    public function down()
    {
        Schema::table('beasiswas', function (Blueprint $table) {
            if (Schema::hasColumn('beasiswas', 'dokumen_pendukung')) {
                $table->dropColumn('dokumen_pendukung');
            }
        });
    }
};