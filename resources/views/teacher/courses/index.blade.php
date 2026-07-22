@extends('layouts.app')

@section('title', 'Course Saya')

@section('content')
<x-page-header title="Course Saya" subtitle="Wadah metadata (mapel + kelas + semester) untuk keperluan input nilai.">
    <x-slot:actions>
        <form method="POST" action="{{ route('teacher.courses.sync') }}">
            @csrf
            <x-button type="submit" variant="primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Sync dari Jadwal
            </x-button>
        </form>
    </x-slot:actions>
</x-page-header>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[500px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Judul</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Kelas</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Semester</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-32 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($courses as $course)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Judul" class="px-4 py-3 font-medium text-gray-800">{{ $course->title }}</td>
                    <td data-label="Kelas" class="px-4 py-3 text-gray-600">{{ $course->schoolClass->name ?? '-' }}</td>
                    <td data-label="Semester" class="px-4 py-3 text-gray-600">{{ $course->semester->name ?? '-' }}</td>
                    <td data-label="Aksi" class="px-4 py-3 text-right">
                        <div class="flex items-center gap-3 justify-end flex-wrap">
                            <a href="{{ route('teacher.grades.show', $course) }}" class="text-primary hover:underline text-sm font-medium">
                                Input Nilai
                            </a>
                            <a href="{{ route('teacher.courses.announcements.create', $course) }}" class="text-gray-500 hover:underline text-sm font-medium">
                                Kirim Pengumuman
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">
                    <x-empty-state message="Belum ada course. Klik &quot;Sync dari Jadwal&quot; di atas (perlu jadwal mengajar dari admin dulu)." />
                </td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>
@endsection
