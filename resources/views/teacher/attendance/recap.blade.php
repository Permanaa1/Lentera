@extends('layouts.app')
@section('title', 'Rekap Absensi')
@section('content')
<x-page-header
    title="Absensi Tanggal Ini"
    :subtitle="($schedule->subject->name ?? '-') . ' — ' . ($schedule->schoolClass->name ?? '-') . ' · ' . \Carbon\Carbon::parse($date)->translatedFormat('d F Y')"
    :back="route('teacher.attendance.index')"
    backLabel="Jadwal Saya">
    <x-slot:actions>
        <x-button href="{{ route('teacher.attendance.create', ['schedule' => $schedule, 'date' => $date, 'edit' => 1]) }}" variant="outline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Absensi Ini
        </x-button>
        <x-button href="{{ route('teacher.attendance.class-recap', $schedule) }}" variant="outline">Rekap Keseluruhan</x-button>
    </x-slot:actions>
</x-page-header>

<div class="bg-info-subtle border-l-4 border-info text-info rounded-r-lg px-4 py-3 text-sm mb-4">
    Data ini sudah tersimpan. Klik "Edit Absensi Ini" untuk mengubahnya -- ini mencegah perubahan tidak sengaja.
</div>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[480px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">NIS</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($attendances as $a)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="NIS" class="px-4 py-3 text-gray-500">{{ $a->student->nis ?? '-' }}</td>
                    <td data-label="Nama" class="px-4 py-3 font-medium text-gray-800">{{ $a->student->user->name ?? '-' }}</td>
                    <td data-label="Status" class="px-4 py-3">
                        @php
                            $labels = ['present' => 'Hadir', 'absent' => 'Alpa', 'sick' => 'Sakit', 'permission' => 'Izin'];
                            $colors = ['present' => 'success', 'absent' => 'danger', 'sick' => 'secondary', 'permission' => 'info'];
                        @endphp
                        <x-badge :color="$colors[$a->status]">{{ $labels[$a->status] }}</x-badge>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3"><x-empty-state message="Belum ada absensi tanggal ini." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>
@endsection
