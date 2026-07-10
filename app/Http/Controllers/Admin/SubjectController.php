<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // Implementasi ELIW-09 (Mengelola data mata pelajaran)

    public function index()
    {
        $subjects = Subject::orderBy('name')->paginate(10);

        return view('admin.subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('admin.subjects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:subjects,code'],
            'name' => ['required', 'string', 'max:100'],
            'credit' => ['required', 'integer', 'min:1', 'max:10'],
            'description' => ['nullable', 'string'],
        ]);

        Subject::create($data);

        return redirect()->route('admin.subjects.index')
            ->with('status', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:subjects,code,' . $subject->id],
            'name' => ['required', 'string', 'max:100'],
            'credit' => ['required', 'integer', 'min:1', 'max:10'],
            'description' => ['nullable', 'string'],
        ]);

        $subject->update($data);

        return redirect()->route('admin.subjects.index')
            ->with('status', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Subject $subject)
    {
        if ($subject->courses()->exists() || $subject->schedules()->exists()) {
            return back()->with('status', 'Tidak bisa menghapus mata pelajaran yang sudah dipakai.');
        }

        $subject->delete();

        return redirect()->route('admin.subjects.index')
            ->with('status', 'Mata pelajaran berhasil dihapus.');
    }
}
