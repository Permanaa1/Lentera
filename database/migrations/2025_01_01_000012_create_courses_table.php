<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Catatan: "courses" = ruang kelas virtual LMS per mata pelajaran (bukan rombel akademik).
        // Digabung dari skema C200 (class_id, subject_id, teacher_id) + class diagram C300 (semester_id).
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('semester_id')->nullable()->constrained('semesters')->nullOnDelete();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->string('class_code', 20)->unique(); // kode join kelas untuk murid
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
