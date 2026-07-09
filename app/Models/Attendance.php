<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['student_id', 'schedule_id', 'course_id', 'attendance_date', 'status'];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // ================= Method (sesuai class diagram) =================

    public static function markAttendance(int $studentId, string $date, string $status, ?int $scheduleId = null, ?int $courseId = null): self
    {
        return static::updateOrCreate(
            [
                'student_id' => $studentId,
                'attendance_date' => $date,
                'schedule_id' => $scheduleId,
                'course_id' => $courseId,
            ],
            ['status' => $status]
        );
    }
}
