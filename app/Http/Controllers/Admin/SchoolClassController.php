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
    public function index(Request $request)
    {
        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        $classes = SchoolClass::with('department', 'academicYear', 'homeroomTeacher.user')
            ->withCount('students')
            ->when($request->filled('search'), fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'))
            ->orderBy('name')
            ->paginate($perPage)
            ->withQueryString();

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
            'tingkat' => ['nullable', 'integer', 'in:10,11,12'],
            'department_id' => ['required', 'exists:departments,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'homeroom_teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        SchoolClass::create($data);

        return redirect()->route('admin.classes.index')->with('status', 'Kelas berhasil ditambahkan.');
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
            'tingkat' => ['nullable', 'integer', 'in:10,11,12'],
            'department_id' => ['required', 'exists:departments,id'],
            'academic_year_id' => ['required', 'exists:academic_years,id'],
            'homeroom_teacher_id' => ['nullable', 'exists:teachers,id'],
        ]);

        $class->update($data);

        return redirect()->route('admin.classes.index')->with('status', 'Kelas berhasil diperbarui.');
    }

    public function destroy(SchoolClass $class)
    {
        if ($class->students()->exists()) {
            return back()->with('status', 'Tidak bisa menghapus kelas yang masih punya murid.');
        }

        $class->delete();

        return redirect()->route('admin.classes.index')->with('status', 'Kelas berhasil dihapus.');
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
