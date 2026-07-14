@extends('layouts.admin')

@section('title', 'Catat Pembayaran Manual')

@section('admin-content')
<h1 class="text-xl font-semibold mb-2">Catat Pembayaran Manual</h1>
<p class="text-sm text-gray-500 mb-6">
    Untuk kasus murid bayar tunai langsung ke TU. Pembayaran ini langsung dianggap terverifikasi.
</p>

<div class="bg-gray-100 p-4 rounded-lg mb-4 text-sm">
    <p><span class="text-gray-500">Murid:</span> {{ $invoice->student->user->name ?? '-' }}</p>
    <p><span class="text-gray-500">Tagihan:</span> {{ ucfirst($invoice->invoice_type) }} — Rp{{ number_format($invoice->amount, 0, ',', '.') }}</p>
</div>

<form method="POST" action="{{ route('admin.invoices.payments.store', $invoice) }}" class="bg-white p-6 rounded-lg shadow space-y-4 max-w-md">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Jumlah Dibayar (Rp)</label>
        <input type="number" name="amount" value="{{ old('amount', $invoice->amount) }}" min="0" step="1000" required
               class="w-full border rounded px-3 py-2 text-sm">
        @error('amount') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Metode Pembayaran</label>
        <select name="payment_method" required class="w-full border rounded px-3 py-2 text-sm">
            <option value="Tunai">Tunai</option>
            <option value="Transfer Bank">Transfer Bank</option>
            <option value="QRIS">QRIS</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">No. Transaksi (opsional)</label>
        <input type="text" name="transaction_number" value="{{ old('transaction_number') }}"
               class="w-full border rounded px-3 py-2 text-sm">
    </div>

    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">Simpan</button>
        <a href="{{ route('admin.invoices.show', $invoice) }}" class="px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-100">Batal</a>
    </div>
</form>
@endsection
