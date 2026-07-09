<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'course_id', 'module_id', 'teacher_id', 'title', 'description', 'status', 'deadline', 'duration_minutes',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function aiGenerationLogs()
    {
        return $this->hasMany(AIGenerationLog::class);
    }

    // ================= Method (sesuai class diagram) =================

    public function publish(): bool
    {
        return $this->update(['status' => 'published']);
    }

    public function close(): bool
    {
        return $this->update(['status' => 'closed']);
    }

    public function isAvailable(): bool
    {
        if ($this->status !== 'published') {
            return false;
        }

        return ! $this->isExpired();
    }

    public function isExpired(): bool
    {
        return $this->deadline !== null && now()->greaterThan($this->deadline);
    }
}
