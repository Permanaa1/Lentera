<?php

namespace App\Http\Controllers\ParentPortal;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Implementasi SRS-49/50 (viewChildProgress, viewChildAttendance) + ELIW-34..39
    // (nilai, absensi, jadwal, tugas, tagihan, riwayat pembayaran anak).

    public function show(Request $request, Student $student)
    {
        $this->authorizeAccess($request, $student);

        $student->load('user', 'schoolClass');

        $grades = $student->grades()->with('course.subject')->get();

        $attendanceRecap = $student->attendances()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $schedules = $student->schoolClass
            ? $student->schoolClass->schedules()->with('subject', 'teacher.user')
                ->orderByRaw("FIELD(day, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
                ->orderBy('start_time')
                ->get()
            : collect();

        $invoices = $student->invoices()->latest('due_date')->get();

        return view('parent.students.show', compact('student', 'grades', 'attendanceRecap', 'schedules', 'invoices'));
    }

    protected function authorizeAccess(Request $request, Student $student): void
    {
        $parentProfile = $request->user()->parentProfile;

        $isLinked = $parentProfile?->students()->where('students.id', $student->id)->exists() ?? false;

        abort_unless($isLinked, 403, 'Murid ini tidak terhubung dengan akun Anda.');
    }
}
