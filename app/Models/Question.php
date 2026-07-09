<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['quiz_id', 'question_text', 'explanation', 'question_type', 'order', 'source'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function attemptAnswers()
    {
        return $this->hasMany(AttemptAnswer::class);
    }

    // ================= Method (sesuai class diagram) =================

    public function getCorrectOption(): ?Option
    {
        return $this->options()->where('is_correct', true)->first();
    }

    public function isFromAI(): bool
    {
        return $this->source === 'ai';
    }

    public function updateOrder(int $newOrder): void
    {
        $this->update(['order' => $newOrder]);
    }
}
