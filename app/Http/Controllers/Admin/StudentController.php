<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 15);
        $perPage = in_array($perPage, [15, 25, 50, 100]) ? $perPage : 15;

        $students = Student::with('user', 'schoolClass')
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('nis', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn ($u) => $u->where('name', 'like', '%' . $request->search . '%'));
            })
            ->when($request->filled('class_id'), fn ($q) => $q->where('class_id', $request->class_id))
            ->when($request->filled('status'), fn ($q) => $q->where('academic_status', $request->status))
            ->when($request->boolean('unassigned'), fn ($q) => $q->whereNull('class_id'))
            ->orderBy('nis')
            ->paginate($perPage)
            ->withQueryString();

        $classes = SchoolClass::orderBy('name')->get();

        return view('admin.students.index', compact('students', 'classes'));
    }

    public function edit(Student $student)
    {
        $classes = SchoolClass::orderBy('name')->get();
        $histories = $student->classHistories()->with('schoolClass', 'academicYear')->get();

        return view('admin.students.edit', compact('student', 'classes', 'histories'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'class_id' => ['nullable', 'exists:classes,id'],
            'academic_status' => ['required', 'in:active,leave,graduated,transferred,dropped_out'],
        ]);

        // Kalau status diubah jadi bukan aktif, kosongkan kelas -- murid yang lulus/pindah/keluar
        // tidak masuk hitungan "murid aktif di kelas X" manapun lagi.
        if ($data['academic_status'] !== 'active' && $data['academic_status'] !== 'leave') {
            $data['class_id'] = null;
        }

        $student->update($data);

        return redirect()->route('admin.students.index')
            ->with('status', "Murid \"{$student->user->name}\" berhasil diperbarui.");
    }
}
