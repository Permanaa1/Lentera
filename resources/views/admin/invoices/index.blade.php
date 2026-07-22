@extends('layouts.admin')
@section('title', 'Tagihan')
@section('admin-content')
<x-page-header title="Tagihan Pendidikan" subtitle="Buat & pantau tagihan murid."
    :breadcrumbs="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Tagihan']]">
    <x-slot:actions>
        <x-button href="{{ route('admin.invoices.create') }}" variant="primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Tagihan
        </x-button>
    </x-slot:actions>
</x-page-header>

<form method="GET" class="flex flex-wrap items-center gap-2 mb-4">
    <x-search-input placeholder="Cari nama murid..." />
    <select name="type" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2.5 min-h-[44px] text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
        <option value="">Semua Jenis</option>
        @foreach (['spp' => 'SPP', 'exam' => 'Ujian', 'activity' => 'Kegiatan', 'book' => 'Buku', 'uniform' => 'Seragam'] as $val => $label)
            <option value="{{ $val }}" {{ request('type') == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    <select name="status" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2.5 min-h-[44px] text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
        <option value="">Semua Status</option>
        @foreach (['unpaid' => 'Belum Bayar', 'paid' => 'Lunas', 'overdue' => 'Terlambat'] as $val => $label)
            <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    <x-button type="submit" variant="outline">Cari</x-button>
</form>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[600px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Murid</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Jenis</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Jumlah</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Jatuh Tempo</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-20 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($invoices as $invoice)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Murid" class="px-4 py-3 font-medium text-gray-800">
                        {{ $invoice->student->user->name ?? '-' }}
                        <span class="text-gray-400 text-xs block sm:inline">({{ $invoice->student->schoolClass->name ?? '-' }})</span>
                    </td>
                    <td data-label="Jenis" class="px-4 py-3"><x-badge color="secondary">{{ strtoupper($invoice->invoice_type) }}</x-badge></td>
                    <td data-label="Jumlah" class="px-4 py-3 font-medium">Rp{{ number_format($invoice->amount, 0, ',', '.') }}</td>
                    <td data-label="Jatuh Tempo" class="px-4 py-3 text-gray-600">{{ $invoice->due_date->format('d M Y') }}</td>
                    <td data-label="Status" class="px-4 py-3">
                        <x-badge :color="match($invoice->status) { 'paid' => 'success', 'overdue' => 'warning', default => 'danger' }">
                            {{ $invoice->status }}
                        </x-badge>
                    </td>
                    <td data-label="Aksi" class="px-4 py-3 text-right">
                        <x-icon-button variant="view" label="Detail" :href="route('admin.invoices.show', $invoice)" />
                    </td>
                </tr>
            @empty
                <tr><td colspan="6"><x-empty-state message="Belum ada tagihan." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>

<div class="mt-4">{{ $invoices->links() }}</div>
@endsection
