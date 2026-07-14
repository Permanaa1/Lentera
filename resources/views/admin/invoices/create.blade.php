@extends('layouts.admin')

@section('title', 'Buat Tagihan')

@section('admin-content')
<h1 class="text-xl font-semibold mb-6">Buat Tagihan</h1>

@if (session('status'))
    <div class="mb-4 px-4 py-3 rounded bg-yellow-100 text-yellow-800 text-sm">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('admin.invoices.store') }}"
      x-data="{ target: '{{ old('target', 'single') }}' }"
      class="bg-white p-6 rounded-lg shadow space-y-4 max-w-md">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Jenis Tagihan</label>
        <select name="invoice_type" required class="w-full border rounded px-3 py-2 text-sm">
            @foreach (['spp' => 'SPP', 'exam' => 'Ujian', 'activity' => 'Kegiatan', 'book' => 'Buku', 'uniform' => 'Seragam'] as $val => $label)
                <option value="{{ $val }}" {{ old('invoice_type') == $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Jumlah (Rp)</label>
        <input type="number" name="amount" value="{{ old('amount') }}" min="0" step="1000" required
               class="w-full border rounded px-3 py-2 text-sm">
        @error('amount') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Jatuh Tempo</label>
        <input type="date" name="due_date" value="{{ old('due_date') }}" required
               class="w-full border rounded px-3 py-2 text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Target Tagihan</label>
        <select name="target" x-model="target" class="w-full border rounded px-3 py-2 text-sm">
            <option value="single">1 Murid Tertentu</option>
            <option value="class">Semua Murid di 1 Kelas</option>
            <option value="all">Semua Murid Aktif (seluruh sekolah)</option>
        </select>
    </div>

    <div x-show="target === 'single'">
        <label class="block text-sm font-medium mb-1">Pilih Murid</label>
        <select name="student_id" class="w-full border rounded px-3 py-2 text-sm">
            <option value="">— Pilih —</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                    {{ $student->nis }} — {{ $student->user->name ?? '-' }}
                </option>
            @endforeach
        </select>
    </div>

    <div x-show="target === 'class'">
        <label class="block text-sm font-medium mb-1">Pilih Kelas</label>
        <select name="class_id" class="w-full border rounded px-3 py-2 text-sm">
            <option value="">— Pilih —</option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
            @endforeach
        </select>
    </div>

    <div x-show="target === 'all'" class="text-xs text-gray-500 bg-yellow-50 border border-yellow-200 rounded px-3 py-2">
        Tagihan akan dibuat untuk SEMUA murid berstatus aktif di seluruh sekolah. Pastikan ini memang yang dimaksud.
    </div>

    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">Buat Tagihan</button>
        <a href="{{ route('admin.invoices.index') }}" class="px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-100">Batal</a>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
