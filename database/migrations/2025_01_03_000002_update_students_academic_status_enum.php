<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Memperluas enum academic_status: sebelumnya cuma active/leave/graduated,
     * sekarang ditambah transferred (pindah sekolah) dan dropped_out (keluar/DO).
     * Laravel Schema Builder tidak bisa MODIFY enum secara portable, jadi pakai raw SQL.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE students MODIFY COLUMN academic_status
            ENUM('active', 'leave', 'graduated', 'transferred', 'dropped_out')
            NOT NULL DEFAULT 'active'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE students MODIFY COLUMN academic_status
            ENUM('active', 'leave', 'graduated')
            NOT NULL DEFAULT 'active'");
    }
};
