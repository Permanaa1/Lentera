@extends('layouts.app')
@section('title', 'Bayar Tagihan')
@section('content')
<x-page-header title="Bayar Tagihan" subtitle="Upload bukti transfer/pembayaran. Admin akan memverifikasi sebelum tagihan dianggap lunas."
    :back="route('student.invoices.index')" backLabel="Tagihan Saya" />

<x-card class="mb-4">
    <p class="text-sm"><span class="text-gray-500">Jenis:</span> <span class="font-medium">{{ ucfirst($invoice->invoice_type) }}</span></p>
    <p class="text-sm"><span class="text-gray-500">Jumlah:</span> <span class="font-semibold">Rp{{ number_format($invoice->amount, 0, ',', '.') }}</span></p>
    <p class="text-sm"><span class="text-gray-500">Jatuh Tempo:</span> {{ $invoice->due_date->format('d M Y') }}</p>
</x-card>

@if ($errors->any())
    <div class="bg-danger-subtle border-l-4 border-danger text-danger rounded-r-lg px-4 py-3 text-sm mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('student.invoices.payments.store', $invoice) }}"
      enctype="multipart/form-data" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf

    <x-input type="number" name="amount" label="Jumlah Dibayar (Rp)" :value="$invoice->amount" min="0" step="1000" required />

    <x-select name="payment_method" label="Metode Pembayaran" required>
        <option value="Transfer Bank">Transfer Bank</option>
        <option value="QRIS">QRIS</option>
        <option value="E-Wallet">E-Wallet</option>
    </x-select>

    <x-input name="transaction_number" label="No. Referensi/Transaksi (opsional)" />

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Pembayaran (JPG/PNG/PDF, maks 2MB)</label>
        <input type="file" name="proof" accept=".jpg,.jpeg,.png,.pdf" required
               class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-primary-subtle file:text-primary file:text-sm
                      focus:outline-none focus:ring-2 focus:ring-primary/20">
    </div>

    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Kirim</x-button>
        <x-button href="{{ route('student.invoices.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
