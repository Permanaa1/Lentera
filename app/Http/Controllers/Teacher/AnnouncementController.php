<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Course;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    // Implementasi ELIW-24 (Mengirim pengumuman kepada murid) -- guru cuma bisa
    // kirim pengumuman untuk course miliknya sendiri (memanfaatkan Course::publishAnnouncement()
    // dari Fase 2, yang course-nya sendiri sudah ada sejak "Sync dari Jadwal" di Fase 8).

    public function index(Request $request)
    {
        $teacher = $request->user()->teacher;

        $announcements = Announcement::whereHas('course', fn ($q) => $q->where('teacher_id', $teacher->id))
            ->with('course')
            ->latest()
            ->paginate(15);

        return view('teacher.announcements.index', compact('announcements'));
    }

    public function create(Request $request, Course $course)
    {
        $this->authorizeCourse($request, $course);

        return view('teacher.announcements.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $this->authorizeCourse($request, $course);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        // Method dari Fase 2.
        $course->publishAnnouncement($data['title'], $data['content'], $request->user()->id);

        return redirect()->route('teacher.announcements.index')
            ->with('status', 'Pengumuman berhasil dikirim ke murid course ini.');
    }

    protected function authorizeCourse(Request $request, Course $course): void
    {
        abort_if($course->teacher_id !== $request->user()->teacher->id, 403, 'Course ini bukan milik Anda.');
    }
}
