@extends('layouts.app')

@section('title', 'Course Saya')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Course Saya</h1>
    <form method="POST" action="{{ route('teacher.courses.sync') }}">
        @csrf
        <button class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">
            Sync Course dari Jadwal
        </button>
    </form>
</div>

<p class="text-xs text-gray-500 mb-4">
    Course di sini cuma wadah metadata (mapel + kelas + semester) untuk keperluan input nilai.
    Fitur materi/kuis belum ada di sini -- menunggu keputusan LMS (custom atau Moodle) di Fase 5.
</p>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Judul</th>
                <th class="px-4 py-2">Kelas</th>
                <th class="px-4 py-2">Semester</th>
                <th class="px-4 py-2 w-32">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($courses as $course)
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium">{{ $course->title }}</td>
                    <td class="px-4 py-2">{{ $course->schoolClass->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $course->semester->name ?? '-' }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('teacher.grades.show', $course) }}" class="text-indigo-600 hover:underline">Input Nilai</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                        Belum ada course. Klik "Sync Course dari Jadwal" di atas (perlu ada jadwal mengajar dari admin dulu).
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
