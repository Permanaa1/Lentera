<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class ReportCardController extends Controller
{
    // Implementasi SRS-45 (generateReportCard) -- versi sederhana (tabel di web),
    // belum berupa PDF cetak. Hanya bisa diakses guru yang berstatus wali kelas
    // (homeroom_teacher_id di tabel classes).

    public function index(Request $request)
    {
        $teacher = $request->user()->teacher;

        $homeroomClasses = SchoolClass::where('homeroom_teacher_id', $teacher->id)
            ->withCount('students')
            ->get();

        return view('teacher.report-card.index', compact('homeroomClasses'));
    }

    public function show(Request $request, SchoolClass $class, Student $student)
    {
        $teacher = $request->user()->teacher;

        abort_if($class->homeroom_teacher_id !== $teacher->id, 403, 'Anda bukan wali kelas ini.');
        abort_if($student->class_id !== $class->id, 404, 'Murid tidak ditemukan di kelas ini.');

        $grades = $student->grades()->with('course.subject')->get();

        $attendanceRecap = $student->attendances()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('teacher.report-card.show', compact('class', 'student', 'grades', 'attendanceRecap'));
    }
}
