@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('admin-content')
<x-page-header title="Riwayat & Verifikasi Pembayaran" subtitle="Pembayaran yang menunggu verifikasi butuh tindakan segera." />

<form method="GET" class="mb-4 text-sm">
    <select name="status" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
        <option value="">Semua Status</option>
        @foreach (['pending' => 'Menunggu Verifikasi', 'verified' => 'Terverifikasi', 'rejected' => 'Ditolak'] as $val => $label)
            <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</form>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[700px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Murid</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Jenis</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Jumlah</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Bukti</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-40">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($payments as $payment)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Tanggal" class="px-4 py-3 text-gray-500">{{ $payment->payment_date?->format('d M Y H:i') ?? '-' }}</td>
                    <td data-label="Murid" class="px-4 py-3 font-medium text-gray-800">{{ $payment->invoice->student->user->name ?? '-' }}</td>
                    <td data-label="Jenis" class="px-4 py-3"><x-badge color="secondary">{{ $payment->invoice->invoice_type ?? '-' }}</x-badge></td>
                    <td data-label="Jumlah" class="px-4 py-3 font-medium">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td data-label="Bukti" class="px-4 py-3">
                        @if ($payment->proof_file_path)
                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($payment->proof_file_path) }}"
                               target="_blank" class="text-primary hover:underline">Lihat</a>
                        @else
                            <span class="text-gray-400 text-xs">manual</span>
                        @endif
                    </td>
                    <td data-label="Status" class="px-4 py-3">
                        <x-badge :color="match($payment->status) { 'verified' => 'success', 'pending' => 'warning', 'rejected' => 'danger', default => 'gray' }">
                            {{ $payment->status }}
                        </x-badge>
                    </td>
                    <td data-label="Aksi" class="px-4 py-3">
                        @if ($payment->status === 'pending')
                            <div class="flex gap-3 justify-end sm:justify-start">
                                <form method="POST" action="{{ route('admin.payments.verify', $payment) }}">
                                    @csrf
                                    <button class="text-success hover:underline text-sm font-medium">Verifikasi</button>
                                </form>
                                <form method="POST" action="{{ route('admin.payments.reject', $payment) }}">
                                    @csrf
                                    <button class="text-danger hover:underline text-sm font-medium">Tolak</button>
                                </form>
                            </div>
                        @else
                            <a href="{{ route('admin.invoices.show', $payment->invoice) }}" class="text-primary hover:underline text-sm font-medium">Detail</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7"><x-empty-state message="Belum ada pembayaran." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>

<div class="mt-4">{{ $payments->links() }}</div>
@endsection
