@extends('layouts.admin')
@section('title', 'Detail Tagihan')
@section('admin-content')
<x-page-header title="Detail Tagihan" :back="route('admin.invoices.index')" backLabel="Tagihan" />

<x-card class="mb-6">
    <div class="space-y-1.5 text-sm">
        <p><span class="text-gray-500">Murid:</span> <span class="font-medium text-gray-800">{{ $invoice->student->user->name ?? '-' }}</span> ({{ $invoice->student->nis }})</p>
        <p><span class="text-gray-500">Jenis:</span> {{ ucfirst($invoice->invoice_type) }}</p>
        <p><span class="text-gray-500">Jumlah:</span> <span class="font-semibold">Rp{{ number_format($invoice->amount, 0, ',', '.') }}</span></p>
        <p><span class="text-gray-500">Jatuh Tempo:</span> {{ $invoice->due_date->format('d M Y') }}</p>
        <p>
            <span class="text-gray-500">Status:</span>
            <x-badge :color="match($invoice->status) { 'paid' => 'success', 'overdue' => 'warning', default => 'danger' }">{{ $invoice->status }}</x-badge>
        </p>
    </div>

    @if ($invoice->status !== 'paid')
        <div class="pt-4 mt-4 border-t border-gray-100 flex flex-wrap gap-2">
            <x-button href="{{ route('admin.invoices.edit', $invoice) }}" variant="outline">Edit Tagihan</x-button>
            <x-button href="{{ route('admin.invoices.payments.create', $invoice) }}" variant="secondary">
                Catat Pembayaran Manual
            </x-button>
        </div>
    @endif
</x-card>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[620px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Jumlah</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Metode</th>
                <th class="px-4 py-3 font-semibold text-gray-600">No. Transaksi</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Bukti</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-32 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($invoice->payments as $payment)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Tanggal" class="px-4 py-3 text-gray-500">{{ $payment->payment_date?->format('d M Y H:i') ?? '-' }}</td>
                    <td data-label="Jumlah" class="px-4 py-3 font-medium">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td data-label="Metode" class="px-4 py-3 text-gray-600">{{ $payment->payment_method ?? '-' }}</td>
                    <td data-label="No. Transaksi" class="px-4 py-3 text-gray-500">{{ $payment->transaction_number ?? '-' }}</td>
                    <td data-label="Bukti" class="px-4 py-3">
                        @if ($payment->proof_file_path)
                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($payment->proof_file_path) }}"
                               target="_blank" class="text-primary hover:underline">Lihat</a>
                        @else
                            <span class="text-gray-400 text-xs">manual</span>
                        @endif
                    </td>
                    <td data-label="Status" class="px-4 py-3">
                        <x-badge :color="match($payment->status) { 'verified' => 'success', 'pending' => 'warning', default => 'danger' }">
                            {{ $payment->status }}
                        </x-badge>
                    </td>
                    <td data-label="Aksi" class="px-4 py-3">
                        @if ($payment->status === 'pending')
                            <div class="flex items-center gap-1 justify-end">
                                <form method="POST" action="{{ route('admin.payments.verify', $payment) }}">
                                    @csrf
                                    <x-icon-button variant="success" label="Verifikasi" />
                                </form>
                                <form method="POST" action="{{ route('admin.payments.reject', $payment) }}">
                                    @csrf
                                    <x-icon-button variant="delete" label="Tolak" />
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7"><x-empty-state message="Belum ada pembayaran." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>
@endsection
