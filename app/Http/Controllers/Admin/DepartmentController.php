<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // Implementasi ELIW-08 (Mengelola data jurusan)

    public function index()
    {
        $departments = Department::withCount('classes')->orderBy('name')->paginate(10);

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:departments,code'],
            'name' => ['required', 'string', 'max:100'],
        ]);

        Department::create($data);

        return redirect()->route('admin.departments.index')
            ->with('status', 'Jurusan berhasil ditambahkan.');
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:departments,code,' . $department->id],
            'name' => ['required', 'string', 'max:100'],
        ]);

        $department->update($data);

        return redirect()->route('admin.departments.index')
            ->with('status', 'Jurusan berhasil diperbarui.');
    }

    public function destroy(Department $department)
    {
        if ($department->classes()->exists()) {
            return back()->with('status', 'Tidak bisa menghapus jurusan yang masih punya kelas.');
        }

        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('status', 'Jurusan berhasil dihapus.');
    }
}
