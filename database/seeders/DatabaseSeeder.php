<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seeder minimal untuk Fase 1 — sekadar memastikan migration bisa diisi
     * dan ada 1 akun admin untuk login pertama kali.
     * Data akademik/kelas/murid dummy yang lebih lengkap sebaiknya
     * dibuat di seeder terpisah pada Fase 4 (Modul Akademik).
     */
    public function run(): void
    {
        // 1. Akun admin default
        $adminId = DB::table('users')->insertGetId([
            'name' => 'Administrator',
            'email' => 'admin@elearning.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Tahun ajaran aktif
        $academicYearId = DB::table('academic_years')->insertGetId([
            'name' => '2026/2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Semester aktif
        DB::table('semesters')->insert([
            'academic_year_id' => $academicYearId,
            'name' => 'Ganjil',
            'start_date' => '2026-07-01',
            'end_date' => '2026-12-31',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Jurusan contoh
        DB::table('departments')->insert([
            'code' => 'IPA',
            'name' => 'Ilmu Pengetahuan Alam',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('Seeder dasar selesai. Login admin: admin@elearning.test / password');
    }
}
