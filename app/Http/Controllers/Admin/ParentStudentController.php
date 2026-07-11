<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentStudent;
use App\Models\ParentUser;
use App\Models\Student;
use Illuminate\Http\Request;

class ParentStudentController extends Controller
{
    // Sebelumnya cuma bisa link parent-student lewat tinker manual (linkStudent()).
    // Ini halaman admin resminya.

    public function index()
    {
        $links = ParentStudent::with('parentUser.user', 'student.user', 'student.schoolClass')
            ->latest()
            ->paginate(15);

        return view('admin.parent-links.index', compact('links'));
    }

    public function create()
    {
        $parents = ParentUser::with('user')->get();
        $students = Student::with('user')->orderBy('nis')->get();

        return view('admin.parent-links.create', compact('parents', 'students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'parent_id' => ['required', 'exists:parents,id'],
            'student_id' => ['required', 'exists:students,id'],
        ]);

        $exists = ParentStudent::where('parent_id', $data['parent_id'])
            ->where('student_id', $data['student_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('status', 'Wali murid ini sudah terhubung ke murid tersebut.');
        }

        // Method dari Fase 2 -- pakai syncWithoutDetaching, aman dipanggil berulang.
        $parent = ParentUser::findOrFail($data['parent_id']);
        $student = Student::findOrFail($data['student_id']);
        $parent->linkStudent($student);

        return redirect()->route('admin.parent-links.index')
            ->with('status', 'Wali murid berhasil dihubungkan ke murid.');
    }

    public function destroy(ParentStudent $parentLink)
    {
        $parentLink->delete();

        return back()->with('status', 'Hubungan wali murid & murid berhasil diputus.');
    }
}
