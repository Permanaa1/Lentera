@extends('layouts.admin')
@section('title', 'Catat Pembayaran Manual')
@section('admin-content')
<x-page-header title="Catat Pembayaran Manual" subtitle="Untuk kasus murid bayar tunai langsung ke TU. Langsung dianggap terverifikasi."
    :back="route('admin.invoices.show', $invoice)" backLabel="Detail Tagihan" />

<x-card class="mb-4">
    <p class="text-sm"><span class="text-gray-500">Murid:</span> <span class="font-medium">{{ $invoice->student->user->name ?? '-' }}</span></p>
    <p class="text-sm"><span class="text-gray-500">Tagihan:</span> {{ ucfirst($invoice->invoice_type) }} — Rp{{ number_format($invoice->amount, 0, ',', '.') }}</p>
</x-card>

<form method="POST" action="{{ route('admin.invoices.payments.store', $invoice) }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf
    <x-input type="number" name="amount" label="Jumlah Dibayar (Rp)" :value="$invoice->amount" min="0" step="1000" required />
    <x-select name="payment_method" label="Metode Pembayaran" required>
        <option value="Tunai">Tunai</option>
        <option value="Transfer Bank">Transfer Bank</option>
        <option value="QRIS">QRIS</option>
    </x-select>
    <x-input name="transaction_number" label="No. Transaksi (opsional)" />
    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Simpan</x-button>
        <x-button href="{{ route('admin.invoices.show', $invoice) }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
