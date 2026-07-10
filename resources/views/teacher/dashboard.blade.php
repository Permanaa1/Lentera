@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<h1 class="text-xl font-semibold mb-2">Dashboard Guru</h1>
<p class="text-sm text-gray-500 mb-6">
    Halo, {{ auth()->user()->name }} — NIP: {{ $teacher->nip ?? '-' }}
</p>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 text-sm">
    <a href="{{ route('teacher.courses.index') }}" class="bg-white p-4 rounded-lg shadow hover:bg-gray-50">
        <p class="font-medium">Course Saya</p>
        <p class="text-gray-500 text-xs mt-1">Sync & lihat course dari jadwal</p>
    </a>
    <a href="{{ route('teacher.attendance.index') }}" class="bg-white p-4 rounded-lg shadow hover:bg-gray-50">
        <p class="font-medium">Kelola Absensi</p>
        <p class="text-gray-500 text-xs mt-1">Isi absensi per jadwal mengajar</p>
    </a>
    <a href="{{ route('teacher.report-card.index') }}" class="bg-white p-4 rounded-lg shadow hover:bg-gray-50">
        <p class="font-medium">Rapor Murid</p>
        <p class="text-gray-500 text-xs mt-1">Khusus wali kelas</p>
    </a>
</div>

<div class="bg-white p-4 rounded-lg shadow">
    <p class="text-sm font-medium mb-3">Course yang Anda ampu ({{ $courses->count() }})</p>

    @forelse ($courses as $course)
        <div class="border-t py-2 text-sm flex justify-between">
            <span>{{ $course->title }} — {{ $course->subject->name ?? '-' }} ({{ $course->schoolClass->name ?? '-' }})</span>
            <a href="{{ route('teacher.grades.show', $course) }}" class="text-indigo-600 hover:underline text-xs">Input Nilai</a>
        </div>
    @empty
        <p class="text-gray-400 italic text-sm">
            Belum ada course. Klik "Course Saya" di atas lalu "Sync Course dari Jadwal".
        </p>
    @endforelse
</div>
@endsection
