<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    // Implementasi ELIW-30 (Melihat hasil nilai pembelajaran).

    public function index(Request $request)
    {
        $student = $request->user()->student;

        $grades = $student->grades()->with('course.subject')->get();

        return view('student.grades.index', compact('grades'));
    }
}
