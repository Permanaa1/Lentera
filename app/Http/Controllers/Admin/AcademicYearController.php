<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    // Implementasi SRS-36 (manageAcademicYear) / ELIW-04

    public function index()
    {
        $academicYears = AcademicYear::orderByDesc('start_date')->paginate(10);

        return view('admin.academic-years.index', compact('academicYears'));
    }

    public function create()
    {
        return view('admin.academic-years.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:20'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ]);

        AcademicYear::create($data);

        return redirect()->route('admin.academic-years.index')
            ->with('status', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function edit(AcademicYear $academic_year)
    {
        return view('admin.academic-years.edit', ['academicYear' => $academic_year]);
    }

    public function update(Request $request, AcademicYear $academic_year)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:20'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ]);

        $academic_year->update($data);

        return redirect()->route('admin.academic-years.index')
            ->with('status', 'Tahun ajaran berhasil diperbarui.');
    }

    public function destroy(AcademicYear $academic_year)
    {
        if ($academic_year->is_active) {
            return back()->with('status', 'Tidak bisa menghapus tahun ajaran yang sedang aktif.');
        }

        $academic_year->delete();

        return redirect()->route('admin.academic-years.index')
            ->with('status', 'Tahun ajaran berhasil dihapus.');
    }

    public function activate(AcademicYear $academic_year)
    {
        // Method activate() di model otomatis menonaktifkan tahun ajaran lain (Fase 2).
        $academic_year->activate();

        return back()->with('status', "Tahun ajaran \"{$academic_year->name}\" sekarang aktif.");
    }
}
