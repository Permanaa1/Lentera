<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // Implementasi ELIW-32 (Melihat riwayat absensi) -- murid lihat rekap & riwayat sendiri.

    public function index(Request $request)
    {
        $student = $request->user()->student;

        $recap = $student->attendances()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $history = $student->attendances()
            ->with('schedule.subject')
            ->latest('attendance_date')
            ->paginate(20);

        return view('student.attendance.index', compact('recap', 'history'));
    }
}
