@extends('layouts.app')

@section('title', 'Tagihan Saya')

@section('content')
<x-page-header title="Tagihan Saya" subtitle="Bayar tagihan pendidikan dan pantau status verifikasinya di sini." />

<div class="space-y-3">
    @forelse ($invoices as $invoice)
        <div class="bg-white p-4 sm:p-5 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <x-badge color="secondary" class="mb-2">{{ strtoupper($invoice->invoice_type) }}</x-badge>
                    <p class="text-xl font-bold text-gray-800">Rp{{ number_format($invoice->amount, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Jatuh tempo: {{ $invoice->due_date->format('d M Y') }}</p>
                </div>
                <x-badge :color="match($invoice->status) { 'paid' => 'success', 'overdue' => 'warning', default => 'danger' }">
                    {{ $invoice->status }}
                </x-badge>
            </div>

            @php $pending = $invoice->payments->firstWhere('status', 'pending'); @endphp

            @if ($invoice->status !== 'paid')
                <div class="mt-3">
                    @if ($pending)
                        <p class="text-xs text-yellow-700 bg-warning-subtle rounded-lg px-3 py-2 inline-flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Menunggu verifikasi admin
                        </p>
                    @else
                        <x-button href="{{ route('student.invoices.payments.create', $invoice) }}" variant="primary">
                            Bayar Sekarang
                        </x-button>
                    @endif
                </div>
            @endif

            @if ($invoice->payments->isNotEmpty())
                <div class="mt-3 pt-3 border-t border-gray-100 text-xs text-gray-500 space-y-1">
                    <p class="font-medium text-gray-600 mb-1">Riwayat pembayaran:</p>
                    @foreach ($invoice->payments as $payment)
                        <p class="flex items-center gap-1.5">
                            {{ $payment->payment_date?->format('d M Y') ?? '-' }} —
                            Rp{{ number_format($payment->amount, 0, ',', '.') }} —
                            <x-badge :color="match($payment->status) { 'verified' => 'success', 'pending' => 'warning', default => 'danger' }">
                                {{ $payment->status }}
                            </x-badge>
                        </p>
                    @endforeach
                </div>
            @endif
        </div>
    @empty
        <x-empty-state message="Belum ada tagihan." />
    @endforelse
</div>
@endsection
