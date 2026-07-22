<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\StudentClassHistory;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    // Implementasi proses kenaikan kelas -- tidak eksplisit ada di SRS dokumen C200/C300,
    // tapi ini kebutuhan nyata operasional sekolah yang sebelumnya belum tercover.

    public function index(Request $request)
    {
        $academicYears = AcademicYear::orderByDesc('start_date')->get();
        $academicYearId = $request->query('academic_year_id', optional($academicYears->first())->id);

        $classes = SchoolClass::where('academic_year_id', $academicYearId)
            ->with('department')
            ->withCount(['students' => fn ($q) => $q->where('academic_status', 'active')])
            ->orderBy('tingkat')
            ->orderBy('name')
            ->get();

        return view('admin.promotions.index', compact('academicYears', 'academicYearId', 'classes'));
    }

    public function show(Request $request, SchoolClass $class)
    {
        $students = $class->students()
            ->where('academic_status', 'active')
            ->with('user')
            ->orderBy('nis')
            ->get()
            ->map(function (Student $student) {
                $student->avg_grade = $student->averageGrade();
                $student->attendance_rate = $student->attendanceRate();

                return $student;
            });

        // Saran kelas tujuan: tingkat+1, jurusan sama, di tahun ajaran BEDA dari kelas asal.
        $suggestedNextClasses = SchoolClass::where('department_id', $class->department_id)
            ->where('tingkat', ($class->tingkat ?? 0) + 1)
            ->where('academic_year_id', '!=', $class->academic_year_id)
            ->with('academicYear')
            ->get();

        // Semua kelas (untuk dropdown manual override per murid).
        $allClasses = SchoolClass::with('academicYear', 'department')
            ->orderByDesc('academic_year_id')
            ->orderBy('tingkat')
            ->get();

        return view('admin.promotions.show', compact('class', 'students', 'suggestedNextClasses', 'allClasses'));
    }

    public function store(Request $request, SchoolClass $class)
    {
        $data = $request->validate([
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'decisions' => ['required', 'array'],
            'decisions.*.student_id' => ['required', 'exists:students,id'],
            'decisions.*.status' => ['required', 'in:promoted,retained,graduated,transferred,dropped_out'],
            'decisions.*.target_class_id' => ['nullable', 'exists:classes,id'],
        ]);

        $processed = 0;

        foreach ($data['decisions'] as $row) {
            $student = Student::find($row['student_id']);
            $status = $row['status'];
            $targetClassId = $row['target_class_id'] ?? null;

            // Catat histori untuk tahun ajaran yang sedang diproses/ditutup.
            StudentClassHistory::updateOrCreate(
                ['student_id' => $student->id, 'academic_year_id' => $data['academic_year_id']],
                [
                    'class_id' => $class->id,
                    'promotion_status' => $status,
                    'decided_at' => now(),
                ]
            );

            if (in_array($status, ['promoted', 'retained'], true)) {
                if (! $targetClassId) {
                    continue; // lewati kalau kelas tujuan belum dipilih -- jangan kosongkan class_id murid tanpa sengaja
                }
                $student->update(['class_id' => $targetClassId, 'academic_status' => 'active']);
            } elseif ($status === 'graduated') {
                $student->update(['class_id' => null, 'academic_status' => 'graduated']);
            } elseif ($status === 'transferred') {
                $student->update(['class_id' => null, 'academic_status' => 'transferred']);
            } elseif ($status === 'dropped_out') {
                $student->update(['class_id' => null, 'academic_status' => 'dropped_out']);
            }

            $processed++;
        }

        return redirect()->route('admin.promotions.index')
            ->with('status', "Keputusan kenaikan kelas untuk {$processed} murid di kelas \"{$class->name}\" berhasil disimpan.");
    }
}
