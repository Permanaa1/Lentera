<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('teachers')->cascadeOnDelete();
            // Diubah dari string bebas menjadi FK ke tabel rooms (Opsi B, perbaikan Fase 4)
            // supaya validasi bentrok ruang akurat (bandingkan ID, bukan teks).
            $table->foreignId('room_id')->nullable()->constrained('rooms')->nullOnDelete();
            $table->string('day', 20); // Senin, Selasa, dst
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
