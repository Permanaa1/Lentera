<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['code', 'name', 'credit', 'description'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // ================= Method (sesuai class diagram) =================

    public function getTeachers()
    {
        return Teacher::whereHas('courses', function ($q) {
            $q->where('subject_id', $this->id);
        })->get();
    }
}
