@extends('layouts.app')

@section('title', 'Tagihan Saya')

@section('content')
<h1 class="text-xl font-semibold mb-6">Tagihan Saya</h1>

<div class="space-y-3">
    @forelse ($invoices as $invoice)
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium uppercase text-sm">{{ $invoice->invoice_type }}</p>
                    <p class="text-lg font-semibold">Rp{{ number_format($invoice->amount, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500">Jatuh tempo: {{ $invoice->due_date->format('d M Y') }}</p>
                </div>
                <div class="text-right">
                    <span @class([
                        'px-2 py-0.5 rounded text-xs',
                        'bg-red-100 text-red-800' => $invoice->status === 'unpaid',
                        'bg-green-100 text-green-800' => $invoice->status === 'paid',
                        'bg-yellow-100 text-yellow-800' => $invoice->status === 'overdue',
                    ])>{{ $invoice->status }}</span>

                    @php $pending = $invoice->payments->firstWhere('status', 'pending'); @endphp

                    @if ($invoice->status !== 'paid')
                        @if ($pending)
                            <p class="text-xs text-yellow-600 mt-2">Menunggu verifikasi admin</p>
                        @else
                            <a href="{{ route('student.invoices.payments.create', $invoice) }}"
                               class="block mt-2 text-sm bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700">
                                Bayar Sekarang
                            </a>
                        @endif
                    @endif
                </div>
            </div>

            @if ($invoice->payments->isNotEmpty())
                <div class="mt-3 pt-3 border-t text-xs text-gray-500">
                    <p class="font-medium mb-1">Riwayat pembayaran:</p>
                    @foreach ($invoice->payments as $payment)
                        <p>
                            {{ $payment->payment_date?->format('d M Y') ?? '-' }} —
                            Rp{{ number_format($payment->amount, 0, ',', '.') }} —
                            <span @class([
                                'font-medium',
                                'text-yellow-600' => $payment->status === 'pending',
                                'text-green-600' => $payment->status === 'verified',
                                'text-red-600' => $payment->status === 'rejected',
                            ])>{{ $payment->status }}</span>
                        </p>
                    @endforeach
                </div>
            @endif
        </div>
    @empty
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-400">Belum ada tagihan.</div>
    @endforelse
</div>
@endsection
