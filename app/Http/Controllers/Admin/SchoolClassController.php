<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    // Implementasi ELIW-07 (Mengelola data kelas / rombel akademik)
    // Catatan: nama file/class controller "SchoolClassController" tapi route resource
    // tetap pakai URI "classes" agar konsisten dengan nama tabel & konsep "kelas" di UI.

    public function index()
    {
        $classes = SchoolClass::with('department', 'academicYear', 'homeroomTeacher.user')
            ->withCount('students')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        [$departments, $academicYears, $teachers] = $this->formOptions();

        return view('admin.classes.create', compact('departments', 'academicYears', 'teachers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'department_id' => ['required', 'exists:departments,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'homeroom_teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        SchoolClass::create($data);

        return redirect()->route('admin.classes.index')
            ->with('status', 'Kelas berhasil ditambahkan.');
    }

    public function edit(SchoolClass $class)
    {
        [$departments, $academicYears, $teachers] = $this->formOptions();

        return view('admin.classes.edit', compact('class', 'departments', 'academicYears', 'teachers'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'department_id' => ['required', 'exists:departments,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'homeroom_teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        $class->update($data);

        return redirect()->route('admin.classes.index')
            ->with('status', 'Kelas berhasil diperbarui.');
    }

    public function destroy(SchoolClass $class)
    {
        if ($class->students()->exists()) {
            return back()->with('status', 'Tidak bisa menghapus kelas yang masih punya murid.');
        }

        $class->delete();

        return redirect()->route('admin.classes.index')
            ->with('status', 'Kelas berhasil dihapus.');
    }

    protected function formOptions(): array
    {
        return [
            Department::orderBy('name')->get(),
            AcademicYear::orderByDesc('start_date')->get(),
            Teacher::with('user')->get(),
        ];
    }
}
