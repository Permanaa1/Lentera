<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['created_by', 'course_id', 'title', 'content', 'target_role'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // ================= Method (sesuai class diagram) =================

    public static function publish(int $createdBy, string $title, string $content, ?int $courseId = null, ?string $targetRole = null): self
    {
        return static::create([
            'created_by' => $createdBy,
            'course_id' => $courseId,
            'title' => $title,
            'content' => $content,
            'target_role' => $targetRole,
        ]);
    }
}
