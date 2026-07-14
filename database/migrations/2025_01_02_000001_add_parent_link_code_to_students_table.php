<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Perbaikan Fase 10: memungkinkan wali murid menghubungkan diri sendiri
        // ke anak pakai kode unik, tanpa wajib lewat admin setiap saat.
        // Cara admin manual (Fase 10 awal) tetap dipertahankan sebagai fallback
        // untuk kasus khusus (wali murid lupa kode, dsb).
        Schema::table('students', function (Blueprint $table) {
            $table->string('parent_link_code', 20)->nullable()->unique()->after('nis');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('parent_link_code');
        });
    }
};
