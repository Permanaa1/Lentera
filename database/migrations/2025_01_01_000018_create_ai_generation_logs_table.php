<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Catatan: tabel ini TIDAK ADA di ERD C200, hanya muncul di class diagram C300.
        // Wajib ditambahkan manual (sesuai catatan proyekmu sendiri) untuk mencatat
        // proses generate soal oleh AI Service secara asynchronous (queue job).
        Schema::create('ai_generation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();
            $table->foreignId('quiz_id')->nullable()->constrained('quizzes')->nullOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->unsignedInteger('question_generated')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_generation_logs');
    }
};
