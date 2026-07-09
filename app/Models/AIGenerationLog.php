<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AIGenerationLog extends Model
{
    protected $table = 'ai_generation_logs';

    protected $fillable = [
        'module_id', 'quiz_id', 'teacher_id', 'status', 'question_generated', 'error_message',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // ================= Method (sesuai class diagram) =================

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isSuccess(): bool
    {
        return $this->status === 'success';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }
}
