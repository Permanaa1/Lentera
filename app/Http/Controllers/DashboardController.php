<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Route generik "/dashboard" -- redirect ke dashboard sesuai role.
     * Berguna sebagai satu link tetap (misal di navbar) tanpa perlu tahu role user dulu.
     */
    public function index(Request $request)
    {
        $role = $request->user()->role;

        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            'parent' => redirect()->route('parent.dashboard'),
            default => redirect()->route('login'),
        };
    }
}
