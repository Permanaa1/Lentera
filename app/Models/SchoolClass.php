<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    // Model diberi nama "SchoolClass" karena "Class" adalah reserved keyword PHP.
    protected $table = 'classes';

    protected $fillable = ['name', 'department_id', 'academic_year_id', 'homeroom_teacher_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function homeroomTeacher()
    {
        return $this->belongsTo(Teacher::class, 'homeroom_teacher_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'class_id');
    }
}
