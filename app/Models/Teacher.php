<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = ['user_id', 'nip', 'specialization'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function homeroomClasses()
    {
        return $this->hasMany(SchoolClass::class, 'homeroom_teacher_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function aiGenerationLogs()
    {
        return $this->hasMany(AIGenerationLog::class);
    }
}
