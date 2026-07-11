<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    // Implementasi ELIW-14 (Mengelola pengumuman akademik) -- level admin,
    // broadcast berdasarkan target_role (bukan per-course, itu domain guru).

    public function index()
    {
        $announcements = Announcement::whereNull('course_id')
            ->with('creator')
            ->latest()
            ->paginate(15);

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'target_role' => ['required', 'in:all,admin,teacher,student,parent'],
        ]);

        Announcement::create([
            'created_by' => $request->user()->id,
            'title' => $data['title'],
            'content' => $data['content'],
            'target_role' => $data['target_role'],
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('status', 'Pengumuman berhasil dipublikasikan.');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return back()->with('status', 'Pengumuman berhasil dihapus.');
    }
}
