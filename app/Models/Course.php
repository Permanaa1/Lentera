<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $fillable = [
        'class_id', 'subject_id', 'teacher_id', 'semester_id', 'title', 'description', 'class_code',
    ];

    protected static function booted(): void
    {
        static::creating(function (Course $course) {
            if (empty($course->class_code)) {
                $course->class_code = $course->generateCode();
            }
        });
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'course_members', 'course_id', 'student_id')
                    ->withPivot('joined_at')
                    ->withTimestamps();
    }

    public function modules()
    {
        return $this->hasMany(Module::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // ================= Method (sesuai class diagram) =================

    public function generateCode(): string
    {
        do {
            $code = strtoupper(Str::random(6));
        } while (static::where('class_code', $code)->exists());

        return $code;
    }

    public function publishAnnouncement(string $title, string $content, int $createdBy): Announcement
    {
        return $this->announcements()->create([
            'title' => $title,
            'content' => $content,
            'created_by' => $createdBy,
        ]);
    }

    public function addMaterial(array $data): Module
    {
        return $this->modules()->create($data);
    }
}
