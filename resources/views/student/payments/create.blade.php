@extends('layouts.app')

@section('title', 'Bayar Tagihan')

@section('content')
<h1 class="text-xl font-semibold mb-2">Bayar Tagihan</h1>
<p class="text-sm text-gray-500 mb-6">Upload bukti transfer/pembayaran. Admin akan memverifikasi sebelum tagihan dianggap lunas.</p>

<div class="bg-gray-100 p-4 rounded-lg mb-4 text-sm">
    <p><span class="text-gray-500">Jenis:</span> {{ ucfirst($invoice->invoice_type) }}</p>
    <p><span class="text-gray-500">Jumlah:</span> Rp{{ number_format($invoice->amount, 0, ',', '.') }}</p>
    <p><span class="text-gray-500">Jatuh Tempo:</span> {{ $invoice->due_date->format('d M Y') }}</p>
</div>

@if ($errors->any())
    <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-700 text-sm">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('student.invoices.payments.store', $invoice) }}"
      enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow space-y-4 max-w-md">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Jumlah Dibayar (Rp)</label>
        <input type="number" name="amount" value="{{ old('amount', $invoice->amount) }}" min="0" step="1000" required
               class="w-full border rounded px-3 py-2 text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Metode Pembayaran</label>
        <select name="payment_method" required class="w-full border rounded px-3 py-2 text-sm">
            <option value="Transfer Bank">Transfer Bank</option>
            <option value="QRIS">QRIS</option>
            <option value="E-Wallet">E-Wallet</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">No. Referensi/Transaksi (opsional)</label>
        <input type="text" name="transaction_number" value="{{ old('transaction_number') }}"
               class="w-full border rounded px-3 py-2 text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Bukti Pembayaran (JPG/PNG/PDF, maks 2MB)</label>
        <input type="file" name="proof" accept=".jpg,.jpeg,.png,.pdf" required
               class="w-full border rounded px-3 py-2 text-sm">
    </div>

    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">Kirim</button>
        <a href="{{ route('student.invoices.index') }}" class="px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-100">Batal</a>
    </div>
</form>
@endsection
