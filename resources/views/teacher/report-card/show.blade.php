@extends('layouts.app')

@section('title', 'Rapor')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Rapor — {{ $student->user->name ?? '-' }}</h1>
    <a href="{{ route('teacher.report-card.index') }}" class="text-sm text-indigo-600 hover:underline">← Daftar Kelas</a>
</div>

<div class="bg-white p-4 rounded-lg shadow mb-6 text-sm">
    <p><span class="text-gray-500">NIS:</span> {{ $student->nis }}</p>
    <p><span class="text-gray-500">Kelas:</span> {{ $class->name }}</p>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden mb-6">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Mata Pelajaran</th>
                <th class="px-4 py-2">Tugas</th>
                <th class="px-4 py-2">Kuis</th>
                <th class="px-4 py-2">Ujian</th>
                <th class="px-4 py-2">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($grades as $grade)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $grade->course->subject->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $grade->assignment_score ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $grade->quiz_score ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $grade->exam_score ?? '-' }}</td>
                    <td class="px-4 py-2 font-medium">{{ $grade->final_score ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada nilai tersimpan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="bg-white p-4 rounded-lg shadow">
    <p class="text-sm font-medium mb-3">Rekap Kehadiran</p>
    <div class="grid grid-cols-4 gap-4 text-sm">
        <div><span class="text-gray-500">Hadir:</span> {{ $attendanceRecap['present'] ?? 0 }}</div>
        <div><span class="text-gray-500">Alpa:</span> {{ $attendanceRecap['absent'] ?? 0 }}</div>
        <div><span class="text-gray-500">Sakit:</span> {{ $attendanceRecap['sick'] ?? 0 }}</div>
        <div><span class="text-gray-500">Izin:</span> {{ $attendanceRecap['permission'] ?? 0 }}</div>
    </div>
</div>
@endsection
