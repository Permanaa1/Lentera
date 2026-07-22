@extends('layouts.admin')
@section('title', 'Edit Tagihan')
@section('admin-content')
<x-page-header :title="'Edit Tagihan — ' . ($invoice->student->user->name ?? '-')" :back="route('admin.invoices.index')" backLabel="Tagihan" />

<form method="POST" action="{{ route('admin.invoices.update', $invoice) }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf @method('PUT')

    <x-select name="invoice_type" label="Jenis Tagihan" required>
        @foreach (['spp' => 'SPP', 'exam' => 'Ujian', 'activity' => 'Kegiatan', 'book' => 'Buku', 'uniform' => 'Seragam'] as $val => $label)
            <option value="{{ $val }}" {{ old('invoice_type', $invoice->invoice_type) == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-select>

    <x-input type="number" name="amount" label="Jumlah (Rp)" :value="$invoice->amount" min="0" step="1000" required />
    <x-input type="date" name="due_date" label="Jatuh Tempo" :value="$invoice->due_date->format('Y-m-d')" required />

    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Update</x-button>
        <x-button href="{{ route('admin.invoices.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
