<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Implementasi SRS-15 / use case scenario "Melakukan Pembayaran" (C200 Tabel 2.13):
    // murid upload bukti pembayaran -> status invoice jadi "Menunggu Verifikasi" -> admin verifikasi (Fase 9).

    public function create(Request $request, Invoice $invoice)
    {
        $this->authorizeInvoice($request, $invoice);

        abort_if($invoice->status === 'paid', 400, 'Tagihan ini sudah lunas.');
        abort_if($invoice->payments()->where('status', 'pending')->exists(), 400, 'Sudah ada pembayaran yang menunggu verifikasi untuk tagihan ini.');

        return view('student.payments.create', compact('invoice'));
    }

    public function store(Request $request, Invoice $invoice)
    {
        $this->authorizeInvoice($request, $invoice);

        abort_if($invoice->status === 'paid', 400, 'Tagihan ini sudah lunas.');
        abort_if($invoice->payments()->where('status', 'pending')->exists(), 400, 'Sudah ada pembayaran yang menunggu verifikasi untuk tagihan ini.');

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'string', 'max:50'],
            'transaction_number' => ['nullable', 'string', 'max:100'],
            // Sesuai NFR-12: batasi tipe & ukuran file upload.
            'proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $path = $request->file('proof')->store('payment-proofs', 'public');

        Payment::create([
            'invoice_id' => $invoice->id,
            'payment_date' => now(),
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'transaction_number' => $data['transaction_number'] ?? null,
            'proof_file_path' => $path,
            'status' => 'pending', // beda dari input admin manual -- ini WAJIB diverifikasi dulu
        ]);

        return redirect()->route('student.invoices.index')
            ->with('status', 'Bukti pembayaran berhasil dikirim. Menunggu verifikasi admin.');
    }

    protected function authorizeInvoice(Request $request, Invoice $invoice): void
    {
        abort_if($invoice->student_id !== $request->user()->student->id, 403, 'Tagihan ini bukan milik Anda.');
    }
}
