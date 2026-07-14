@extends('layouts.admin')

@section('title', 'Detail Tagihan')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Detail Tagihan</h1>
    <a href="{{ route('admin.invoices.index') }}" class="text-sm text-indigo-600 hover:underline">← Daftar Tagihan</a>
</div>

<div class="bg-white p-4 rounded-lg shadow mb-6 text-sm space-y-1">
    <p><span class="text-gray-500">Murid:</span> {{ $invoice->student->user->name ?? '-' }} ({{ $invoice->student->nis }})</p>
    <p><span class="text-gray-500">Jenis:</span> {{ ucfirst($invoice->invoice_type) }}</p>
    <p><span class="text-gray-500">Jumlah:</span> Rp{{ number_format($invoice->amount, 0, ',', '.') }}</p>
    <p><span class="text-gray-500">Jatuh Tempo:</span> {{ $invoice->due_date->format('d M Y') }}</p>
    <p>
        <span class="text-gray-500">Status:</span>
        <span @class([
            'px-2 py-0.5 rounded text-xs',
            'bg-red-100 text-red-800' => $invoice->status === 'unpaid',
            'bg-green-100 text-green-800' => $invoice->status === 'paid',
            'bg-yellow-100 text-yellow-800' => $invoice->status === 'overdue',
        ])>{{ $invoice->status }}</span>
    </p>

    @if ($invoice->status !== 'paid')
        <div class="pt-3 flex gap-3">
            <a href="{{ route('admin.invoices.edit', $invoice) }}" class="text-indigo-600 hover:underline text-sm">Edit Tagihan</a>
            <a href="{{ route('admin.invoices.payments.create', $invoice) }}" class="text-green-600 hover:underline text-sm">
                Catat Pembayaran Manual
            </a>
        </div>
    @endif
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-4 py-3 border-b font-medium text-sm">Riwayat Pembayaran</div>
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Jumlah</th>
                <th class="px-4 py-2">Metode</th>
                <th class="px-4 py-2">No. Transaksi</th>
                <th class="px-4 py-2">Bukti</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2 w-32">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoice->payments as $payment)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $payment->payment_date?->format('d M Y H:i') ?? '-' }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $payment->payment_method ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $payment->transaction_number ?? '-' }}</td>
                    <td class="px-4 py-2">
                        @if ($payment->proof_file_path)
                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($payment->proof_file_path) }}" target="_blank"
                               class="text-indigo-600 hover:underline">Lihat Bukti</a>
                        @else
                            <span class="text-gray-400">— (input manual)</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <span @class([
                            'px-2 py-0.5 rounded text-xs',
                            'bg-yellow-100 text-yellow-800' => $payment->status === 'pending',
                            'bg-green-100 text-green-800' => $payment->status === 'verified',
                            'bg-red-100 text-red-800' => $payment->status === 'rejected',
                        ])>{{ $payment->status }}</span>
                    </td>
                    <td class="px-4 py-2">
                        @if ($payment->status === 'pending')
                            <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" class="inline">
                                @csrf
                                <button class="text-green-600 hover:underline text-xs">Verifikasi</button>
                            </form>
                            <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="inline">
                                @csrf
                                <button class="text-red-600 hover:underline text-xs">Tolak</button>
                            </form>
                        @else
                            <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-6 text-center text-gray-400">Belum ada pembayaran.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
