<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentStudent extends Model
{
    // Model eksplisit untuk pivot parent_student, dipakai kalau butuh
    // query langsung ke tabel pivotnya (di luar relasi belongsToMany).
    protected $table = 'parent_student';

    protected $fillable = ['parent_id', 'student_id'];

    public function parentUser()
    {
        return $this->belongsTo(ParentUser::class, 'parent_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
