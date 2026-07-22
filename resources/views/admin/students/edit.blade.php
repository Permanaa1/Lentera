@extends('layouts.admin')
@section('title', 'Edit Murid')
@section('admin-content')
<x-page-header :title="'Edit Murid — ' . ($student->user->name ?? '-')" :back="route('admin.students.index')" backLabel="Kelola Murid" />

<form method="POST" action="{{ route('admin.students.update', $student) }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md mb-6">
    @csrf @method('PUT')

    <x-select name="class_id" label="Kelas">
        <option value="">— Belum ditempatkan —</option>
        @foreach ($classes as $class)
            <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                {{ $class->name }}
            </option>
        @endforeach
    </x-select>

    <x-select name="academic_status" label="Status Akademik" required>
        @foreach (['active' => 'Aktif', 'leave' => 'Cuti', 'graduated' => 'Lulus', 'transferred' => 'Pindah Sekolah', 'dropped_out' => 'Keluar/DO'] as $val => $label)
            <option value="{{ $val }}" {{ old('academic_status', $student->academic_status) == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </x-select>
    <p class="text-xs text-gray-400 -mt-3">Status selain Aktif/Cuti otomatis melepas murid dari kelas manapun.</p>

    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Simpan</x-button>
        <x-button href="{{ route('admin.students.index') }}" variant="outline">Batal</x-button>
    </div>
</form>

<x-card title="Riwayat Kelas">
    @forelse ($histories as $h)
        <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0 text-sm">
            <div>
                <span class="font-medium text-gray-800">{{ $h->academicYear->name ?? '-' }}</span>
                <span class="text-gray-400">— {{ $h->schoolClass->name ?? '-' }}</span>
            </div>
            @php
                $labels = ['ongoing' => 'Berjalan', 'promoted' => 'Naik', 'retained' => 'Tidak Naik', 'graduated' => 'Lulus', 'transferred' => 'Pindah', 'dropped_out' => 'Keluar'];
                $colors = ['ongoing' => 'gray', 'promoted' => 'success', 'retained' => 'warning', 'graduated' => 'primary', 'transferred' => 'info', 'dropped_out' => 'danger'];
            @endphp
            <x-badge :color="$colors[$h->promotion_status]">{{ $labels[$h->promotion_status] }}</x-badge>
        </div>
    @empty
        <p class="text-sm text-gray-400">Belum ada riwayat kenaikan kelas untuk murid ini.</p>
    @endforelse
</x-card>
@endsection
