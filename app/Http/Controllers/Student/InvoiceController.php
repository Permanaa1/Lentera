<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Implementasi ELIW-33 (Melakukan pembayaran tagihan pendidikan) -- bagian lihat daftar tagihan.
    // Sengaja TIDAK bergantung ke Course/LMS -- murni relasi Student->Invoice yang sudah ada sejak Fase 1.

    public function index(Request $request)
    {
        $student = $request->user()->student;

        $invoices = $student->invoices()->with('payments')->latest('due_date')->get();

        return view('student.invoices.index', compact('invoices'));
    }
}
