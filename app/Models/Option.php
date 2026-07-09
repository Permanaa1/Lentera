<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['question_id', 'option_text', 'option_label', 'is_correct'];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
        ];
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function attemptAnswers()
    {
        return $this->hasMany(AttemptAnswer::class, 'chosen_option_id');
    }

    // ================= Method (sesuai class diagram) =================

    public function markAsCorrect(): void
    {
        // Pastikan cuma 1 opsi benar per soal.
        $this->question->options()->update(['is_correct' => false]);
        $this->update(['is_correct' => true]);
    }

    public function toClientArray(): array
    {
        // Sengaja TIDAK menyertakan is_correct saat dikirim ke murid (dipakai di halaman kerjakan kuis).
        return [
            'id' => $this->id,
            'option_label' => $this->option_label,
            'option_text' => $this->option_text,
        ];
    }
}
