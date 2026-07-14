@extends('layouts.admin')

@section('title', 'Edit Tagihan')

@section('admin-content')
<h1 class="text-xl font-semibold mb-6">Edit Tagihan — {{ $invoice->student->user->name ?? '-' }}</h1>

<form method="POST" action="{{ route('admin.invoices.update', $invoice) }}" class="bg-white p-6 rounded-lg shadow space-y-4 max-w-md">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium mb-1">Jenis Tagihan</label>
        <select name="invoice_type" required class="w-full border rounded px-3 py-2 text-sm">
            @foreach (['spp' => 'SPP', 'exam' => 'Ujian', 'activity' => 'Kegiatan', 'book' => 'Buku', 'uniform' => 'Seragam'] as $val => $label)
                <option value="{{ $val }}" {{ old('invoice_type', $invoice->invoice_type) == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Jumlah (Rp)</label>
        <input type="number" name="amount" value="{{ old('amount', $invoice->amount) }}" min="0" step="1000" required
               class="w-full border rounded px-3 py-2 text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Jatuh Tempo</label>
        <input type="date" name="due_date" value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}" required
               class="w-full border rounded px-3 py-2 text-sm">
    </div>

    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">Update</button>
        <a href="{{ route('admin.invoices.index') }}" class="px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-100">Batal</a>
    </div>
</form>
@endsection
