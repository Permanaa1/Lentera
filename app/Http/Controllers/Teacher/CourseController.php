<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Schedule;
use App\Models\Semester;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Course "container" minimal -- cuma metadata (mapel + kelas + semester),
     * TANPA fitur materi/kuis (itu tetap domain Fase 5, custom atau Moodle).
     * Dibuat sekarang semata supaya modul Nilai (Fase 8) punya sesuatu untuk dipakai.
     */
    public function index(Request $request)
    {
        $teacher = $request->user()->teacher;

        $courses = Course::where('teacher_id', $teacher->id)
            ->with('subject', 'schoolClass', 'semester')
            ->orderByDesc('id')
            ->get();

        return view('teacher.courses.index', compact('courses'));
    }

    /**
     * Generate/sinkronkan Course dari jadwal mengajar guru ini.
     * 1 kombinasi (kelas + mapel) unik di jadwal -> 1 Course (kalau belum ada).
     */
    public function sync(Request $request)
    {
        $teacher = $request->user()->teacher;

        $activeSemester = Semester::whereHas('academicYear', fn ($q) => $q->where('is_active', true))
            ->latest('start_date')
            ->first();

        if (! $activeSemester) {
            return back()->with('status', 'Belum ada semester untuk tahun ajaran aktif. Minta admin membuatnya dulu.');
        }

        $combinations = Schedule::where('teacher_id', $teacher->id)
            ->with('subject', 'schoolClass')
            ->get()
            ->unique(fn ($s) => $s->class_id . '-' . $s->subject_id);

        if ($combinations->isEmpty()) {
            return back()->with('status', 'Anda belum punya jadwal mengajar apapun. Minta admin membuatkan jadwal dulu.');
        }

        $created = 0;

        foreach ($combinations as $combo) {
            $exists = Course::where('teacher_id', $teacher->id)
                ->where('class_id', $combo->class_id)
                ->where('subject_id', $combo->subject_id)
                ->where('semester_id', $activeSemester->id)
                ->exists();

            if (! $exists) {
                Course::create([
                    'class_id' => $combo->class_id,
                    'subject_id' => $combo->subject_id,
                    'teacher_id' => $teacher->id,
                    'semester_id' => $activeSemester->id,
                    'title' => $combo->subject->name . ' - ' . $combo->schoolClass->name,
                ]);
                $created++;
            }
        }

        $message = $created > 0
            ? "{$created} course baru berhasil disinkronkan dari jadwal Anda."
            : 'Tidak ada course baru -- semua kombinasi kelas & mapel di jadwal Anda sudah punya course.';

        return back()->with('status', $message);
    }
}
