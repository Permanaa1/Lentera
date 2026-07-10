<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // Implementasi SRS-42 (recordAttendance) & SRS-43 (viewAttendanceRecap) /
    // use case scenario "Kelola Absensi" (C200 Tabel 2.12).
    // Sengaja TIDAK bergantung ke Course -- langsung dari Schedule (Fase 4),
    // supaya berfungsi penuh terlepas dari keputusan custom-LMS vs Moodle.

    public function index(Request $request)
    {
        $teacher = $request->user()->teacher;

        $schedules = Schedule::where('teacher_id', $teacher->id)
            ->with('subject', 'schoolClass')
            ->orderByRaw("FIELD(day, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->get();

        return view('teacher.attendance.index', compact('schedules'));
    }

    public function create(Request $request, Schedule $schedule)
    {
        $this->authorizeSchedule($request, $schedule);

        $date = $request->query('date', now()->toDateString());

        $students = $schedule->schoolClass->students()->with('user')->orderBy('nis')->get();

        $existing = Attendance::where('schedule_id', $schedule->id)
            ->where('attendance_date', $date)
            ->get()
            ->keyBy('student_id');

        return view('teacher.attendance.create', compact('schedule', 'students', 'existing', 'date'));
    }

    public function store(Request $request, Schedule $schedule)
    {
        $this->authorizeSchedule($request, $schedule);

        $data = $request->validate([
            'attendance_date' => ['required', 'date'],
            'statuses' => ['required', 'array'],
            'statuses.*.student_id' => ['required', 'exists:students,id'],
            'statuses.*.status' => ['required', 'in:present,absent,sick,permission'],
        ]);

        foreach ($data['statuses'] as $row) {
            Attendance::markAttendance(
                studentId: $row['student_id'],
                date: $data['attendance_date'],
                status: $row['status'],
                scheduleId: $schedule->id,
            );
        }

        return redirect()
            ->route('teacher.attendance.recap', ['schedule' => $schedule, 'date' => $data['attendance_date']])
            ->with('status', 'Absensi berhasil disimpan.');
    }

    public function recap(Request $request, Schedule $schedule)
    {
        $this->authorizeSchedule($request, $schedule);

        $date = $request->query('date', now()->toDateString());

        $attendances = Attendance::where('schedule_id', $schedule->id)
            ->where('attendance_date', $date)
            ->with('student.user')
            ->get();

        return view('teacher.attendance.recap', compact('schedule', 'attendances', 'date'));
    }

    protected function authorizeSchedule(Request $request, Schedule $schedule): void
    {
        abort_if($schedule->teacher_id !== $request->user()->teacher->id, 403, 'Jadwal ini bukan milik Anda.');
    }
}
