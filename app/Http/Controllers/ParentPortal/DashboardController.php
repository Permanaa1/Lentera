<?php

namespace App\Http\Controllers\ParentPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $parentProfile = $request->user()->parentProfile;

        // Checkpoint testing: pastikan relasi User -> ParentUser -> Student (pivot parent_student) nyambung.
        $students = $parentProfile?->students()->with('schoolClass', 'user')->get() ?? collect();

        return view('parent.dashboard', compact('parentProfile', 'students'));
    }
}
