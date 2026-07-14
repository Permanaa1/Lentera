@extends('layouts.admin')

@section('title', 'Pembayaran')

@section('admin-content')
<h1 class="text-xl font-semibold mb-6">Riwayat & Verifikasi Pembayaran</h1>

<form method="GET" class="mb-4 text-sm">
    <select name="status" class="border rounded px-2 py-1" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        @foreach (['pending' => 'Menunggu Verifikasi', 'verified' => 'Terverifikasi', 'rejected' => 'Ditolak'] as $val => $label)
            <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Murid</th>
                <th class="px-4 py-2">Jenis Tagihan</th>
                <th class="px-4 py-2">Jumlah</th>
                <th class="px-4 py-2">Bukti</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2 w-32">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $payment->payment_date?->format('d M Y H:i') ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $payment->invoice->student->user->name ?? '-' }}</td>
                    <td class="px-4 py-2 uppercase text-xs">{{ $payment->invoice->invoice_type ?? '-' }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">
                        @if ($payment->proof_file_path)
                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($payment->proof_file_path) }}"
                               target="_blank" class="text-indigo-600 hover:underline">Lihat</a>
                        @else
                            <span class="text-gray-400 text-xs">manual</span>
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
                    <td class="px-4 py-2 space-x-2">
                        @if ($payment->status === 'pending')
                            <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" class="inline">
                                @csrf
                                <button class="text-green-600 hover:underline">Verifikasi</button>
                            </form>
                            <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="inline">
                                @csrf
                                <button class="text-red-600 hover:underline">Tolak</button>
                            </form>
                        @else
                            <a href="{{ route('admin.invoices.show', $payment->invoice) }}" class="text-indigo-600 hover:underline">Detail</a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-6 text-center text-gray-400">Belum ada pembayaran.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $payments->links() }}</div>
@endsection
