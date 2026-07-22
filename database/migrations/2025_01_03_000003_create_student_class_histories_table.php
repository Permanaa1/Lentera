<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jejak riwayat penempatan kelas murid per tahun ajaran -- supaya "murid ini
     * dulu di kelas apa tahun kemarin" tidak hilang begitu students.class_id
     * diubah saat proses kenaikan kelas. students.class_id tetap dipertahankan
     * sebagai "kelas saat ini" (dipakai di seluruh sistem yang sudah ada),
     * tabel ini murni catatan historis + hasil keputusan kenaikan kelas.
     */
    public function up(): void
    {
        Schema::create('student_class_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
            $table->foreignId('academic_year_id')->constrained('academic_years')->cascadeOnDelete();
            $table->enum('promotion_status', ['ongoing', 'promoted', 'retained', 'graduated', 'transferred', 'dropped_out'])
                  ->default('ongoing');
            $table->text('notes')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'academic_year_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_class_histories');
    }
};
