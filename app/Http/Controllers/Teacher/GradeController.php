<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    // Implementasi SRS-44 (inputFinalGrade) / use case scenario "Input Nilai" (C200 Tabel 2.11)

    public function show(Request $request, Course $course)
    {
        $this->authorizeCourse($request, $course);

        $students = $course->schoolClass->students()->with('user')->orderBy('nis')->get();

        // Ambil grade yang sudah ada, index by student_id supaya gampang dicocokkan di view.
        $grades = Grade::where('course_id', $course->id)
            ->get()
            ->keyBy('student_id');

        return view('teacher.grades.show', compact('course', 'students', 'grades'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorizeCourse($request, $course);

        $data = $request->validate([
            'scores' => ['required', 'array'],
            'scores.*.student_id' => ['required', 'exists:students,id'],
            'scores.*.assignment_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'scores.*.quiz_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'scores.*.exam_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        foreach ($data['scores'] as $row) {
            $grade = Grade::firstOrNew([
                'student_id' => $row['student_id'],
                'course_id' => $course->id,
            ]);

            $grade->assignment_score = $row['assignment_score'] ?? null;
            $grade->quiz_score = $row['quiz_score'] ?? null;
            $grade->exam_score = $row['exam_score'] ?? null;
            $grade->save();

            // Method dari Fase 2 -- otomatis hitung & simpan final_score (bobot 40/30/30).
            $grade->calculateFinalScore();
        }

        return back()->with('status', 'Nilai berhasil disimpan.');
    }

    protected function authorizeCourse(Request $request, Course $course): void
    {
        abort_if($course->teacher_id !== $request->user()->teacher->id, 403, 'Course ini bukan milik Anda.');
    }
}
