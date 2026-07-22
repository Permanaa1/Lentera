@extends('layouts.app')
@section('title', 'Rapor')
@section('content')
<x-page-header :title="'Rapor — ' . ($student->user->name ?? '-')" :back="route('teacher.report-card.index')" backLabel="Rapor Murid" />

<x-card class="mb-6">
    <p class="text-sm"><span class="text-gray-500">NIS:</span> <span class="font-medium">{{ $student->nis }}</span></p>
    <p class="text-sm"><span class="text-gray-500">Kelas:</span> {{ $class->name }}</p>
</x-card>

<x-table-wrapper class="mb-6">
    <table class="responsive-table w-full text-sm min-w-[520px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Mata Pelajaran</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Tugas</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Kuis</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Ujian</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($grades as $grade)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Mata Pelajaran" class="px-4 py-3 font-medium text-gray-800">{{ $grade->course->subject->name ?? '-' }}</td>
                    <td data-label="Tugas" class="px-4 py-3 text-gray-600">{{ $grade->assignment_score ?? '-' }}</td>
                    <td data-label="Kuis" class="px-4 py-3 text-gray-600">{{ $grade->quiz_score ?? '-' }}</td>
                    <td data-label="Ujian" class="px-4 py-3 text-gray-600">{{ $grade->exam_score ?? '-' }}</td>
                    <td data-label="Nilai Akhir" class="px-4 py-3 font-semibold text-primary">{{ $grade->final_score ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5"><x-empty-state message="Belum ada nilai tersimpan." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>

<x-card title="Rekap Kehadiran">
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
        <div><span class="text-gray-500 block text-xs">Hadir</span> <span class="font-semibold text-success">{{ $attendanceRecap['present'] ?? 0 }}</span></div>
        <div><span class="text-gray-500 block text-xs">Alpa</span> <span class="font-semibold text-danger">{{ $attendanceRecap['absent'] ?? 0 }}</span></div>
        <div><span class="text-gray-500 block text-xs">Sakit</span> <span class="font-semibold text-yellow-700">{{ $attendanceRecap['sick'] ?? 0 }}</span></div>
        <div><span class="text-gray-500 block text-xs">Izin</span> <span class="font-semibold text-info">{{ $attendanceRecap['permission'] ?? 0 }}</span></div>
    </div>
</x-card>
@endsection
