<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Module extends Model
{
    protected $fillable = [
        'course_id', 'teacher_id', 'title', 'file_path', 'file_size', 'content', 'visibility',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function aiGenerationLogs()
    {
        return $this->hasMany(AIGenerationLog::class);
    }

    // ================= Method (sesuai class diagram) =================
    // Catatan: uploadFile() & generateQuizzesViaAI() di sini hanya kerangka dasar.
    // Implementasi penuh (validasi file, panggil AI Service via Job) dikerjakan
    // di Service/Controller pada Fase 5 & Fase 6, model cukup jadi representasi data.

    public function uploadFile(\Illuminate\Http\UploadedFile $file): bool
    {
        $path = $file->store('modules', 'public');

        return $this->update([
            'file_path' => $path,
            'file_size' => intdiv($file->getSize(), 1024), // KB
        ]);
    }

    public function getFileUrl(): string
    {
        return Storage::disk('public')->url($this->file_path);
    }

    public function getFileSizeKB(): float
    {
        return (float) $this->file_size;
    }

    public function generateQuizzesViaAI(int $count): bool
    {
        // Placeholder — logic asli: dispatch job GenerateQuizFromModuleJob (Fase 6).
        // Sengaja tidak diimplementasi penuh di sini agar model tetap ringan (thin model).
        return true;
    }
}
