<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    // Implementasi SRS-37 (manageSemester) / ELIW-05

    public function index()
    {
        $semesters = Semester::with('academicYear')->orderByDesc('start_date')->paginate(10);

        return view('admin.semesters.index', compact('semesters'));
    }

    public function create()
    {
        $academicYears = AcademicYear::orderByDesc('start_date')->get();

        return view('admin.semesters.create', compact('academicYears'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'name' => ['required', 'string', 'max:20'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ]);

        Semester::create($data);

        return redirect()->route('admin.semesters.index')
            ->with('status', 'Semester berhasil ditambahkan.');
    }

    public function edit(Semester $semester)
    {
        $academicYears = AcademicYear::orderByDesc('start_date')->get();

        return view('admin.semesters.edit', compact('semester', 'academicYears'));
    }

    public function update(Request $request, Semester $semester)
    {
        $data = $request->validate([
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'name' => ['required', 'string', 'max:20'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ]);

        $semester->update($data);

        return redirect()->route('admin.semesters.index')
            ->with('status', 'Semester berhasil diperbarui.');
    }

    public function destroy(Semester $semester)
    {
        if ($semester->courses()->exists()) {
            return back()->with('status', 'Tidak bisa menghapus semester yang sudah dipakai di course.');
        }

        $semester->delete();

        return redirect()->route('admin.semesters.index')
            ->with('status', 'Semester berhasil dihapus.');
    }
}
