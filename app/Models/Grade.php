<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id', 'course_id', 'assignment_score', 'quiz_score', 'exam_score', 'final_score',
    ];

    protected function casts(): array
    {
        return [
            'assignment_score' => 'decimal:2',
            'quiz_score' => 'decimal:2',
            'exam_score' => 'decimal:2',
            'final_score' => 'decimal:2',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // ================= Method (sesuai class diagram) =================
    // Bobot penilaian (40/30/30) masih asumsi awal — sesuaikan dengan
    // ketentuan institusi saat implementasi Fase 8.

    public function calculateFinalScore(): float
    {
        $final = (float) (($this->assignment_score ?? 0) * 0.4)
               + (float) (($this->quiz_score ?? 0) * 0.3)
               + (float) (($this->exam_score ?? 0) * 0.3);

        $this->update(['final_score' => round($final, 2)]);

        return round($final, 2);
    }
}
