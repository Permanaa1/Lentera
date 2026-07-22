@extends('layouts.admin')
@section('title', 'Buat Tagihan')
@section('admin-content')
<x-page-header title="Buat Tagihan" :back="route('admin.invoices.index')" backLabel="Tagihan" />

<form method="POST" action="{{ route('admin.invoices.store') }}"
      x-data="{ target: '{{ old('target', 'single') }}' }"
      class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf

    <x-select name="invoice_type" label="Jenis Tagihan" required>
        @foreach (['spp' => 'SPP', 'exam' => 'Ujian', 'activity' => 'Kegiatan', 'book' => 'Buku', 'uniform' => 'Seragam'] as $val => $label)
            <option value="{{ $val }}" {{ old('invoice_type') == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-select>

    <x-input type="number" name="amount" label="Jumlah (Rp)" min="0" step="1000" required />
    <x-input type="date" name="due_date" label="Jatuh Tempo" required />

    <x-select name="target" label="Target Tagihan" x-model="target">
        <option value="single">1 Murid Tertentu</option>
        <option value="class">Semua Murid di 1 Kelas</option>
        <option value="all">Semua Murid Aktif (seluruh sekolah)</option>
    </x-select>

    <div x-show="target === 'single'" x-cloak>
        <x-select name="student_id" label="Pilih Murid">
            <option value="">— Pilih —</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                    {{ $student->nis }} — {{ $student->user->name ?? '-' }}
                </option>
            @endforeach
        </x-select>
    </div>

    <div x-show="target === 'class'" x-cloak>
        <x-select name="class_id" label="Pilih Kelas">
            <option value="">— Pilih —</option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
            @endforeach
        </x-select>
    </div>

    <div x-show="target === 'all'" x-cloak class="text-xs text-yellow-800 bg-warning-subtle rounded-lg px-3 py-2">
        Tagihan akan dibuat untuk SEMUA murid berstatus aktif di seluruh sekolah.
    </div>

    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Buat Tagihan</x-button>
        <x-button href="{{ route('admin.invoices.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
