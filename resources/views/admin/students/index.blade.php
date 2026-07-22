@extends('layouts.admin')
@section('title', 'Kelola Murid')
@section('admin-content')
<x-page-header title="Kelola Murid" subtitle="Tempatkan murid ke kelas & atur status akademik."
    :breadcrumbs="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Kelola Murid']]">
    <x-slot:actions>
        <x-button href="{{ route('admin.promotions.index') }}" variant="secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
            Proses Kenaikan Kelas
        </x-button>
    </x-slot:actions>
</x-page-header>

<form method="GET" class="flex flex-wrap items-center gap-2 mb-4">
    <x-search-input placeholder="Cari NIS/nama murid..." />
    <select name="class_id" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2.5 min-h-[44px] text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
        <option value="">Semua Kelas</option>
        @foreach ($classes as $class)
            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
        @endforeach
    </select>
    <select name="status" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2.5 min-h-[44px] text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
        <option value="">Semua Status</option>
        @foreach (['active' => 'Aktif', 'leave' => 'Cuti', 'graduated' => 'Lulus', 'transferred' => 'Pindah', 'dropped_out' => 'Keluar/DO'] as $val => $label)
            <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>
    <label class="flex items-center gap-1.5 text-sm text-gray-600 px-2">
        <input type="checkbox" name="unassigned" value="1" {{ request('unassigned') ? 'checked' : '' }} onchange="this.form.submit()"
               class="rounded border-gray-300 text-primary focus:ring-primary">
        Belum punya kelas
    </label>
    <x-button type="submit" variant="outline">Cari</x-button>
</form>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[640px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">NIS</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Kelas</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Kode Wali Murid</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-20 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($students as $student)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="NIS" class="px-4 py-3 text-gray-600">{{ $student->nis }}</td>
                    <td data-label="Nama" class="px-4 py-3 font-medium text-gray-800">{{ $student->user->name ?? '-' }}</td>
                    <td data-label="Kelas" class="px-4 py-3">
                        @if ($student->schoolClass)
                            {{ $student->schoolClass->name }}
                        @else
                            <span class="text-gray-400 text-xs">—</span>
                        @endif
                    </td>
                    <td data-label="Kode Wali Murid" class="px-4 py-3 font-mono text-xs text-gray-500">{{ $student->parent_link_code }}</td>
                    <td data-label="Status" class="px-4 py-3">
                        @php
                            $labels = ['active' => 'Aktif', 'leave' => 'Cuti', 'graduated' => 'Lulus', 'transferred' => 'Pindah', 'dropped_out' => 'Keluar/DO'];
                            $colors = ['active' => 'success', 'leave' => 'warning', 'graduated' => 'primary', 'transferred' => 'info', 'dropped_out' => 'danger'];
                        @endphp
                        <x-badge :color="$colors[$student->academic_status] ?? 'gray'">{{ $labels[$student->academic_status] ?? $student->academic_status }}</x-badge>
                    </td>
                    <td data-label="Aksi" class="px-4 py-3 text-right">
                        <x-icon-button variant="edit" label="Edit" :href="route('admin.students.edit', $student)" />
                    </td>
                </tr>
            @empty
                <tr><td colspan="6"><x-empty-state message="Belum ada murid dengan filter ini." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>

<p class="text-xs text-gray-400 mt-3">
    "Kode Wali Murid" dibagikan ke orang tua/wali supaya mereka bisa menghubungkan akun sendiri
    lewat halaman "Hubungkan Anak", tanpa perlu admin setiap saat.
</p>

<div class="mt-4">{{ $students->links() }}</div>
@endsection
