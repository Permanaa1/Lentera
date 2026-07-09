<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = ['course_id', 'title', 'description', 'due_date', 'total_score'];

    protected function casts(): array
    {
        return [
            'due_date' => 'datetime',
            'total_score' => 'decimal:2',
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    // ================= Method (sesuai class diagram) =================

    public function publish(): bool
    {
        // due_date tidak diubah; publish di sini berarti assignment sudah bisa diakses murid.
        // Karena skema tidak punya kolom status khusus, tandai lewat event/log jika diperlukan nanti.
        return true;
    }

    public function close(): bool
    {
        return $this->update(['due_date' => now()]);
    }
}
