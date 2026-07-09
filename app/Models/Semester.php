<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = ['academic_year_id', 'name', 'start_date', 'end_date'];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    // ================= Method (sesuai class diagram) =================

    public function isActive(): bool
    {
        $today = now()->toDateString();
        return $today >= $this->start_date->toDateString()
            && $today <= $this->end_date->toDateString();
    }
}
