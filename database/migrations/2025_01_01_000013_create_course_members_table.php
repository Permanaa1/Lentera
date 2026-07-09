<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Catatan: tabel ini tidak eksplisit ada di ERD C200, tapi dibutuhkan
        // untuk mendukung use case "Murid bergabung ke kelas menggunakan kode" (SRS-11)
        // dan merepresentasikan entity ClassMember pada class diagram C300.
        Schema::create('course_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamps();

            $table->unique(['course_id', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_members');
    }
};
