@extends('layouts.app')
@section('title', 'Rekap Absensi Keseluruhan')
@section('content')
<x-page-header
    title="Rekap Absensi"
    :subtitle="($schedule->subject->name ?? '-') . ' — ' . ($schedule->schoolClass->name ?? '-') . ' · Total pertemuan: ' . $totalMeetings"
    :back="route('teacher.attendance.index')"
    backLabel="Jadwal Saya" />

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[520px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">NIS</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Hadir</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Alpa</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Sakit</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Izin</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($students as $student)
                @php $c = $counts->get($student->id, collect())->pluck('total', 'status'); @endphp
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="NIS" class="px-4 py-3 text-gray-500">{{ $student->nis }}</td>
                    <td data-label="Nama" class="px-4 py-3 font-medium text-gray-800">{{ $student->user->name ?? '-' }}</td>
                    <td data-label="Hadir" class="px-4 py-3 text-success font-semibold">{{ $c['present'] ?? 0 }}</td>
                    <td data-label="Alpa" class="px-4 py-3 text-danger font-semibold">{{ $c['absent'] ?? 0 }}</td>
                    <td data-label="Sakit" class="px-4 py-3 text-yellow-700 font-semibold">{{ $c['sick'] ?? 0 }}</td>
                    <td data-label="Izin" class="px-4 py-3 text-info font-semibold">{{ $c['permission'] ?? 0 }}</td>
                </tr>
            @empty
                <tr><td colspan="6"><x-empty-state message="Belum ada murid di kelas ini." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>
@endsection
