@extends('layouts.app')

@section('title', 'Kelola Absensi')

@section('content')
<h1 class="text-xl font-semibold mb-6">Jadwal Mengajar Saya</h1>
<p class="text-sm text-gray-500 mb-4">Pilih salah satu jadwal untuk mengisi absensi hari ini.</p>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Hari</th>
                <th class="px-4 py-2">Jam</th>
                <th class="px-4 py-2">Kelas</th>
                <th class="px-4 py-2">Mata Pelajaran</th>
                <th class="px-4 py-2 w-32">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($schedules as $schedule)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $schedule->day }}</td>
                    <td class="px-4 py-2">{{ substr($schedule->start_time, 0, 5) }}–{{ substr($schedule->end_time, 0, 5) }}</td>
                    <td class="px-4 py-2">{{ $schedule->schoolClass->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $schedule->subject->name ?? '-' }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('teacher.attendance.create', $schedule) }}" class="text-indigo-600 hover:underline">Isi Absensi</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada jadwal mengajar. Minta admin membuatkan dulu.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
