@extends('layouts.admin')

@section('title', 'Tagihan')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Tagihan Pendidikan</h1>
    <a href="{{ route('admin.invoices.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">+ Buat Tagihan</a>
</div>

<form method="GET" class="flex gap-3 mb-4 text-sm">
    <select name="type" class="border rounded px-2 py-1" onchange="this.form.submit()">
        <option value="">Semua Jenis</option>
        @foreach (['spp' => 'SPP', 'exam' => 'Ujian', 'activity' => 'Kegiatan', 'book' => 'Buku', 'uniform' => 'Seragam'] as $val => $label)
            <option value="{{ $val }}" {{ request('type') == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    <select name="status" class="border rounded px-2 py-1" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        @foreach (['unpaid' => 'Belum Bayar', 'paid' => 'Lunas', 'overdue' => 'Terlambat'] as $val => $label)
            <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Murid</th>
                <th class="px-4 py-2">Jenis</th>
                <th class="px-4 py-2">Jumlah</th>
                <th class="px-4 py-2">Jatuh Tempo</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2 w-32">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($invoices as $invoice)
                <tr class="border-t">
                    <td class="px-4 py-2">
                        {{ $invoice->student->user->name ?? '-' }}
                        <span class="text-gray-400 text-xs">({{ $invoice->student->schoolClass->name ?? '-' }})</span>
                    </td>
                    <td class="px-4 py-2 uppercase text-xs">{{ $invoice->invoice_type }}</td>
                    <td class="px-4 py-2">Rp{{ number_format($invoice->amount, 0, ',', '.') }}</td>
                    <td class="px-4 py-2">{{ $invoice->due_date->format('d M Y') }}</td>
                    <td class="px-4 py-2">
                        <span @class([
                            'px-2 py-0.5 rounded text-xs',
                            'bg-red-100 text-red-800' => $invoice->status === 'unpaid',
                            'bg-green-100 text-green-800' => $invoice->status === 'paid',
                            'bg-yellow-100 text-yellow-800' => $invoice->status === 'overdue',
                        ])>
                            {{ $invoice->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.invoices.show', $invoice) }}" class="text-indigo-600 hover:underline">Detail</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada tagihan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $invoices->links() }}</div>
@endsection
