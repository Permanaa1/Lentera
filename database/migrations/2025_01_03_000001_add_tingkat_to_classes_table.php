<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tingkat kelas (10/11/12) dibutuhkan untuk menentukan urutan kenaikan kelas
        // (X -> XI -> XII -> Lulus) secara otomatis, bukan cuma dari nama teks bebas.
        Schema::table('classes', function (Blueprint $table) {
            $table->unsignedTinyInteger('tingkat')->nullable()->after('name'); // 10, 11, atau 12
        });
    }

    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('tingkat');
        });
    }
};
