@extends('layouts.app')
@section('title', 'Absensi Saya')
@section('content')
<x-page-header title="Absensi Saya" />

<x-card class="mb-6" title="Rekap Keseluruhan">
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
        <div><span class="text-gray-500 block text-xs">Hadir</span> <span class="font-semibold text-success text-lg">{{ $recap['present'] ?? 0 }}</span></div>
        <div><span class="text-gray-500 block text-xs">Alpa</span> <span class="font-semibold text-danger text-lg">{{ $recap['absent'] ?? 0 }}</span></div>
        <div><span class="text-gray-500 block text-xs">Sakit</span> <span class="font-semibold text-yellow-700 text-lg">{{ $recap['sick'] ?? 0 }}</span></div>
        <div><span class="text-gray-500 block text-xs">Izin</span> <span class="font-semibold text-info text-lg">{{ $recap['permission'] ?? 0 }}</span></div>
    </div>
</x-card>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[420px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Tanggal</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Mata Pelajaran</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($history as $a)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Tanggal" class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($a->attendance_date)->translatedFormat('d M Y') }}</td>
                    <td data-label="Mata Pelajaran" class="px-4 py-3 font-medium text-gray-800">{{ $a->schedule->subject->name ?? '-' }}</td>
                    <td data-label="Status" class="px-4 py-3">
                        @php
                            $labels = ['present' => 'Hadir', 'absent' => 'Alpa', 'sick' => 'Sakit', 'permission' => 'Izin'];
                            $colors = ['present' => 'success', 'absent' => 'danger', 'sick' => 'secondary', 'permission' => 'info'];
                        @endphp
                        <x-badge :color="$colors[$a->status]">{{ $labels[$a->status] }}</x-badge>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3"><x-empty-state message="Belum ada riwayat absensi." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>

<div class="mt-4">{{ $history->links() }}</div>
@endsection
