<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Implementasi ELIW-12 (Melakukan verifikasi pembayaran) / use case scenario
    // "Verifikasi Pembayaran" (C200 Tabel 2.14).
    //
    // Karena portal murid (upload bukti bayar sendiri) belum dibuat, controller ini
    // juga menyediakan "Catat Pembayaran Manual" -- untuk kasus murid bayar tunai
    // langsung ke TU, dan sekaligus jadi cara test alur verifikasi sebelum
    // portal murid ada.

    public function index(Request $request)
    {
        $payments = Payment::with('invoice.student.user')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest('payment_date')
            ->paginate(15)
            ->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function create(Invoice $invoice)
    {
        abort_if($invoice->status === 'paid', 400, 'Tagihan ini sudah lunas.');

        return view('admin.payments.create', compact('invoice'));
    }

    public function store(Request $request, Invoice $invoice)
    {
        abort_if($invoice->status === 'paid', 400, 'Tagihan ini sudah lunas.');

        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'string', 'max:50'],
            'transaction_number' => ['nullable', 'string', 'max:100'],
        ]);

        // Pembayaran yang dicatat manual oleh admin (bukan upload murid)
        // langsung dianggap terverifikasi -- admin yang input = sudah menerima uangnya.
        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'payment_date' => now(),
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'transaction_number' => $data['transaction_number'] ?? null,
            'status' => 'verified',
        ]);

        $invoice->markAsPaid();

        return redirect()->route('admin.invoices.show', $invoice)
            ->with('status', 'Pembayaran berhasil dicatat dan tagihan otomatis lunas.');
    }

    public function verify(Payment $payment)
    {
        abort_if($payment->status !== 'pending', 400, 'Pembayaran ini sudah diproses sebelumnya.');

        // Method dari Fase 2 -- otomatis panggil $invoice->markAsPaid() juga.
        $payment->verifyPayment(true);

        return back()->with('status', 'Pembayaran berhasil diverifikasi.');
    }

    public function reject(Payment $payment)
    {
        abort_if($payment->status !== 'pending', 400, 'Pembayaran ini sudah diproses sebelumnya.');

        $payment->verifyPayment(false);

        return back()->with('status', 'Pembayaran ditolak.');
    }
}
