<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttemptAnswer extends Model
{
    protected $fillable = ['attempt_id', 'question_id', 'chosen_option_id', 'is_correct', 'answered_at'];

    protected function casts(): array
    {
        return [
            'is_correct' => 'boolean',
            'answered_at' => 'datetime',
        ];
    }

    public function attempt()
    {
        return $this->belongsTo(Attempt::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function chosenOption()
    {
        return $this->belongsTo(Option::class, 'chosen_option_id');
    }

    // ================= Method (sesuai class diagram) =================

    public function validateAnswer(): bool
    {
        if (! $this->chosen_option_id) {
            return false;
        }

        $isCorrect = $this->chosenOption?->is_correct ?? false;
        $this->update(['is_correct' => $isCorrect]);

        return $isCorrect;
    }
}
