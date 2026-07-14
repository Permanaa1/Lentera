@extends('layouts.app')

@section('title', 'Rekap Absensi Keseluruhan')

@section('content')
<div class="flex items-center justify-between mb-2">
    <h1 class="text-xl font-semibold">
        Rekap Absensi — {{ $schedule->subject->name ?? '-' }} ({{ $schedule->schoolClass->name ?? '-' }})
    </h1>
    <a href="{{ route('teacher.attendance.index') }}" class="text-sm text-indigo-600 hover:underline">← Jadwal Saya</a>
</div>
<p class="text-sm text-gray-500 mb-6">Total pertemuan tercatat: {{ $totalMeetings }}</p>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">NIS</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Hadir</th>
                <th class="px-4 py-2">Alpa</th>
                <th class="px-4 py-2">Sakit</th>
                <th class="px-4 py-2">Izin</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
                @php $studentCounts = $counts->get($student->id, collect())->pluck('total', 'status'); @endphp
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $student->nis }}</td>
                    <td class="px-4 py-2">{{ $student->user->name ?? '-' }}</td>
                    <td class="px-4 py-2 text-green-700 font-medium">{{ $studentCounts['present'] ?? 0 }}</td>
                    <td class="px-4 py-2 text-red-700 font-medium">{{ $studentCounts['absent'] ?? 0 }}</td>
                    <td class="px-4 py-2 text-yellow-700 font-medium">{{ $studentCounts['sick'] ?? 0 }}</td>
                    <td class="px-4 py-2 text-blue-700 font-medium">{{ $studentCounts['permission'] ?? 0 }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada murid di kelas ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
