@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<x-page-header title="Dashboard Guru" :subtitle="'NIP: ' . ($teacher->nip ?? '-')" />

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <a href="{{ route('teacher.courses.index') }}"
       class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-primary/30 transition group">
        <div class="w-10 h-10 rounded-lg bg-primary-subtle flex items-center justify-center mb-3 group-hover:bg-primary group-hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        </div>
        <p class="font-medium text-gray-800">Course Saya</p>
        <p class="text-gray-400 text-xs mt-1">Sync & lihat course dari jadwal</p>
    </a>
    <a href="{{ route('teacher.attendance.index') }}"
       class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-primary/30 transition group">
        <div class="w-10 h-10 rounded-lg bg-success-subtle flex items-center justify-center mb-3 group-hover:bg-success group-hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="font-medium text-gray-800">Kelola Absensi</p>
        <p class="text-gray-400 text-xs mt-1">Isi absensi per jadwal mengajar</p>
    </a>
    <a href="{{ route('teacher.report-card.index') }}"
       class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-primary/30 transition group">
        <div class="w-10 h-10 rounded-lg bg-secondary-subtle flex items-center justify-center mb-3 group-hover:bg-secondary group-hover:text-primary-dark transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <p class="font-medium text-gray-800">Rapor Murid</p>
        <p class="text-gray-400 text-xs mt-1">Khusus wali kelas</p>
    </a>
</div>

<x-card title="Course yang Anda Ampu">
    <div class="divide-y divide-gray-100 -mx-5">
        @forelse ($courses as $course)
            <div class="px-5 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $course->title }}</p>
                    <p class="text-xs text-gray-400">{{ $course->subject->name ?? '-' }} — {{ $course->schoolClass->name ?? '-' }}</p>
                </div>
                <a href="{{ route('teacher.grades.show', $course) }}" class="text-primary hover:underline text-xs font-medium shrink-0">
                    Input Nilai →
                </a>
            </div>
        @empty
            <x-empty-state message="Belum ada course. Buka &quot;Course Saya&quot; lalu klik Sync Course dari Jadwal." />
        @endforelse
    </div>
</x-card>
@endsection
