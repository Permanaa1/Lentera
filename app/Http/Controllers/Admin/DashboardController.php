<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Checkpoint testing: menampilkan angka sederhana untuk memastikan
        // relasi Model dari Fase 2 benar-benar terbaca dari database.
        $stats = [
            'total_users' => User::count(),
            'total_teachers' => Teacher::count(),
            'total_students' => Student::count(),
            'total_courses' => Course::count(),
            'pending_teachers' => User::where('role', 'teacher')->where('status', 'pending')->count(),
            'active_academic_year' => AcademicYear::where('is_active', true)->first(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
