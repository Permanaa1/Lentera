<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseMember extends Model
{
    // Representasi entity "ClassMember" pada class diagram C300.
    protected $fillable = ['course_id', 'student_id', 'joined_at'];

    protected function casts(): array
    {
        return [
            'joined_at' => 'datetime',
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // ================= Method (sesuai class diagram) =================

    public function leaveClass(): bool
    {
        return (bool) $this->delete();
    }
}
