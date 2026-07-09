<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Catatan: diperluas dari versi sederhana C200 dengan kolom gamifikasi
        // dari class diagram C300 (game_mode, challenge_mode, boss_id, map_id,
        // streak_max, multiplier_max, progress_percentage).
        // boss_id & map_id TIDAK di-FK-kan karena belum ada tabel bosses/maps
        // di dokumen manapun -- desain lanjutan gamifikasi jadi tanggung jawabmu.
        Schema::create('attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->enum('game_mode', ['boss', 'expedition'])->nullable();
            $table->enum('challenge_mode', ['normal', 'time', 'accuracy', 'survival', 'team'])
                  ->default('normal');
            $table->unsignedBigInteger('boss_id')->nullable();
            $table->unsignedBigInteger('map_id')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->decimal('score', 5, 2)->default(0);
            $table->unsignedInteger('streak_max')->default(0);
            $table->decimal('multiplier_max', 4, 2)->default(1.00);
            $table->decimal('progress_percentage', 5, 2)->default(0);
            $table->enum('status', ['ongoing', 'finished'])->default('ongoing');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attempts');
    }
};
