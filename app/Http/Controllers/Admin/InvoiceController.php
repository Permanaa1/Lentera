<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // Implementasi ELIW-11 (Mengelola data tagihan pendidikan)

    public function index(Request $request)
    {
        $invoices = Invoice::with('student.user', 'student.schoolClass')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('type'), fn ($q) => $q->where('invoice_type', $request->type))
            ->latest('due_date')
            ->paginate(15)
            ->withQueryString();

        return view('admin.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('name')->get();
        $students = Student::with('user')->orderBy('nis')->get();

        return view('admin.invoices.create', compact('classes', 'students'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_type' => ['required', 'in:spp,exam,activity,book,uniform'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['required', 'date'],
            'target' => ['required', 'in:single,class,all'],
            'student_id' => ['required_if:target,single', 'nullable', 'exists:students,id'],
            'class_id' => ['required_if:target,class', 'nullable', 'exists:classes,id'],
        ]);

        $students = match ($data['target']) {
            'single' => Student::where('id', $data['student_id'])->get(),
            'class' => Student::where('class_id', $data['class_id'])->where('academic_status', 'active')->get(),
            'all' => Student::where('academic_status', 'active')->get(),
        };

        if ($students->isEmpty()) {
            return back()->withInput()->with('status', 'Tidak ada murid aktif yang cocok dengan target yang dipilih.');
        }

        foreach ($students as $student) {
            // Method static dari Fase 2 -- otomatis set status 'unpaid'.
            Invoice::generateInvoice($student->id, $data['invoice_type'], $data['amount'], $data['due_date']);
        }

        return redirect()->route('admin.invoices.index')
            ->with('status', "{$students->count()} tagihan berhasil dibuat.");
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('student.user', 'payments');

        return view('admin.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        abort_if($invoice->status === 'paid', 400, 'Tidak bisa mengubah tagihan yang sudah lunas.');

        return view('admin.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        abort_if($invoice->status === 'paid', 400, 'Tidak bisa mengubah tagihan yang sudah lunas.');

        $data = $request->validate([
            'invoice_type' => ['required', 'in:spp,exam,activity,book,uniform'],
            'amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['required', 'date'],
        ]);

        $invoice->update($data);

        return redirect()->route('admin.invoices.index')
            ->with('status', 'Tagihan berhasil diperbarui.');
    }

    public function destroy(Invoice $invoice)
    {
        if ($invoice->payments()->exists()) {
            return back()->with('status', 'Tidak bisa menghapus tagihan yang sudah punya riwayat pembayaran.');
        }

        $invoice->delete();

        return redirect()->route('admin.invoices.index')
            ->with('status', 'Tagihan berhasil dihapus.');
    }
}
