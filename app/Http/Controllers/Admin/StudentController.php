<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Memperbaiki gap Fase 4: sebelumnya admin bisa bikin SchoolClass, tapi
    // tidak ada halaman untuk menempatkan murid ke kelas itu (students.class_id
    // selalu kosong). Ini murni akademik (AIS), tidak menyentuh Course/LMS.

    public function index(Request $request)
    {
        $students = Student::with('user', 'schoolClass')
            ->when($request->filled('class_id'), fn ($q) => $q->where('class_id', $request->class_id))
            ->when($request->filled('unassigned'), fn ($q) => $q->whereNull('class_id'))
            ->orderBy('nis')
            ->paginate(15)
            ->withQueryString();

        $classes = SchoolClass::orderBy('name')->get();

        return view('admin.students.index', compact('students', 'classes'));
    }

    public function edit(Student $student)
    {
        $classes = SchoolClass::orderBy('name')->get();

        return view('admin.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'class_id' => ['nullable', 'exists:classes,id'],
            'academic_status' => ['required', 'in:active,leave,graduated'],
        ]);

        $student->update($data);

        return redirect()->route('admin.students.index')
            ->with('status', "Murid \"{$student->user->name}\" berhasil diperbarui.");
    }
}
