<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $teacher = $request->user()->teacher;

        // Checkpoint testing: pastikan relasi User -> Teacher -> Course nyambung.
        $courses = $teacher?->courses()->with('subject', 'schoolClass')->get() ?? collect();

        return view('teacher.dashboard', compact('teacher', 'courses'));
    }
}
