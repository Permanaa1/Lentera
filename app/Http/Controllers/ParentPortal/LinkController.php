<?php

namespace App\Http\Controllers\ParentPortal;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    // Self-service linking pakai kode -- alternatif dari admin manual link (Fase 10 awal).
    // Kode didapat wali murid dari sekolah/admin secara offline (mis. dicetak di kartu murid).

    public function create()
    {
        return view('parent.link.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string'],
        ]);

        $student = Student::where('parent_link_code', strtoupper(trim($data['code'])))->first();

        if (! $student) {
            return back()->withInput()->with('status', 'Kode tidak ditemukan. Pastikan kode benar (case tidak masalah, tanpa spasi).');
        }

        $parentProfile = $request->user()->parentProfile;

        $alreadyLinked = $parentProfile->students()->where('students.id', $student->id)->exists();

        if ($alreadyLinked) {
            return back()->with('status', 'Anda sudah terhubung dengan murid ini sebelumnya.');
        }

        // Method dari Fase 2.
        $parentProfile->linkStudent($student);

        return redirect()->route('parent.dashboard')
            ->with('status', "Berhasil terhubung dengan {$student->user->name}.");
    }
}
