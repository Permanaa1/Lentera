<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $teacher = $request->user()->teacher;

        $schedules = Schedule::where('teacher_id', $teacher->id)
            ->with('subject', 'schoolClass')
            ->orderByRaw("FIELD(day, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->get();

        return view('teacher.attendance.index', compact('schedules'));
    }

    /**
     * PERBAIKAN UX: kalau absensi tanggal ini SUDAH pernah diisi, jangan langsung
     * tampilkan form yang bisa ditimpa sembarangan -- arahkan dulu ke halaman rekap
     * (read-only). Guru harus sengaja klik "Edit Absensi Ini" untuk masuk mode ubah.
     * Ini mencegah radio button ke-klik tidak sengaja lalu ke-save tanpa sadar.
     */
    public function create(Request $request, Schedule $schedule)
    {
        $this->authorizeSchedule($request, $schedule);

        $date = $request->query('date', now()->toDateString());

        $existing = Attendance::where('schedule_id', $schedule->id)
            ->where('attendance_date', $date)
            ->get()
            ->keyBy('student_id');

        if ($existing->isNotEmpty() && ! $request->boolean('edit')) {
            return redirect()->route('teacher.attendance.recap', ['schedule' => $schedule, 'date' => $date]);
        }

        $students = $schedule->schoolClass->students()->with('user')->orderBy('nis')->get();

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

    /**
     * BARU: rekap keseluruhan (semua tanggal yang pernah diisi) per jadwal --
     * total hadir/alpa/sakit/izin per murid, bukan cuma 1 tanggal.
     */
    public function classRecap(Request $request, Schedule $schedule)
    {
        $this->authorizeSchedule($request, $schedule);

        $students = $schedule->schoolClass->students()->with('user')->orderBy('nis')->get();

        $counts = Attendance::where('schedule_id', $schedule->id)
            ->selectRaw('student_id, status, count(*) as total')
            ->groupBy('student_id', 'status')
            ->get()
            ->groupBy('student_id');

        $totalMeetings = Attendance::where('schedule_id', $schedule->id)
            ->distinct('attendance_date')
            ->count('attendance_date');

        return view('teacher.attendance.class-recap', compact('schedule', 'students', 'counts', 'totalMeetings'));
    }

    protected function authorizeSchedule(Request $request, Schedule $schedule): void
    {
        abort_if($schedule->teacher_id !== $request->user()->teacher->id, 403, 'Jadwal ini bukan milik Anda.');
    }
}
