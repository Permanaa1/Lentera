<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentUser extends Model
{
    // Nama model sengaja "ParentUser" (bukan "Parent") agar tidak rancu
    // dengan konteks lain, walau "Parent" sendiri valid sebagai nama class di PHP.
    protected $table = 'parents';

    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'parent_student', 'parent_id', 'student_id')
                    ->withTimestamps();
    }

    // ================= Method (sesuai class diagram: ParentStudent.linkStudent) =================

    public function linkStudent(Student $student): void
    {
        $this->students()->syncWithoutDetaching([$student->id]);
    }
}
