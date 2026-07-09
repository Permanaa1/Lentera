<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['user_id', 'class_id', 'nis', 'academic_status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function parents()
    {
        return $this->belongsToMany(ParentUser::class, 'parent_student', 'student_id', 'parent_id')
                    ->withTimestamps();
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_members', 'student_id', 'course_id')
                    ->withPivot('joined_at')
                    ->withTimestamps();
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // ================= Method =================

    public function isActive(): bool
    {
        return $this->academic_status === 'active';
    }
}
