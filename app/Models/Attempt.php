<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    protected $fillable = [
        'quiz_id', 'student_id', 'game_mode', 'challenge_mode', 'boss_id', 'map_id',
        'started_at', 'finished_at', 'score', 'streak_max', 'multiplier_max',
        'progress_percentage', 'status',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
            'score' => 'decimal:2',
            'multiplier_max' => 'decimal:2',
            'progress_percentage' => 'decimal:2',
        ];
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function answers()
    {
        return $this->hasMany(AttemptAnswer::class);
    }

    // ================= Method (sesuai class diagram) =================
    // Catatan: implementasi detail (hitung skor/streak per jawaban, logic boss/expedition)
    // dikerjakan lebih lengkap di Fase 7 (Service khusus kuis interaktif).
    // Di sini disediakan kerangka dasarnya agar model tetap merepresentasikan kontrak method.

    public function startAttempt(): bool
    {
        return $this->update([
            'started_at' => now(),
            'status' => 'ongoing',
        ]);
    }

    public function submitAnswer(int $questionId, ?int $optionId): AttemptAnswer
    {
        $isCorrect = $optionId
            ? Option::where('id', $optionId)->where('is_correct', true)->exists()
            : false;

        return $this->answers()->updateOrCreate(
            ['question_id' => $questionId],
            [
                'chosen_option_id' => $optionId,
                'is_correct' => $isCorrect,
                'answered_at' => now(),
            ]
        );
    }

    public function updateScore(): void
    {
        $correctCount = $this->answers()->where('is_correct', true)->count();
        $totalQuestions = $this->quiz->questions()->count();

        $score = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100, 2) : 0;

        $this->update(['score' => $score]);
    }

    public function updateProgress(): void
    {
        $answered = $this->answers()->count();
        $totalQuestions = $this->quiz->questions()->count();

        $progress = $totalQuestions > 0 ? round(($answered / $totalQuestions) * 100, 2) : 0;

        $this->update(['progress_percentage' => $progress]);
    }

    public function finishAttempt(): bool
    {
        $this->updateScore();

        return $this->update([
            'finished_at' => now(),
            'status' => 'finished',
            'progress_percentage' => 100,
        ]);
    }
}
