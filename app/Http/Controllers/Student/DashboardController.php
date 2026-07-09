<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $student = $request->user()->student;

        // Checkpoint testing: pastikan relasi User -> Student -> Course (via course_members) nyambung.
        $courses = $student?->courses()->with('subject', 'teacher.user')->get() ?? collect();

        return view('student.dashboard', compact('student', 'courses'));
    }
}
