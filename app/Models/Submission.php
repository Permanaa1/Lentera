<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    // Table fisiknya "assignment_submissions", nama model mengikuti class diagram: Submission.
    protected $table = 'assignment_submissions';

    protected $fillable = ['assignment_id', 'student_id', 'file_path', 'submitted_at', 'score', 'feedback'];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'score' => 'decimal:2',
        ];
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // ================= Method (sesuai class diagram) =================

    public function submit(string $filePath): bool
    {
        return $this->update([
            'file_path' => $filePath,
            'submitted_at' => now(),
        ]);
    }
}
