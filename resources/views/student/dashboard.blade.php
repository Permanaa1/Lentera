@extends('layouts.app')

@section('title', 'Dashboard Murid')

@section('content')
<x-page-header
    title="Dashboard Murid"
    :subtitle="'NIS: ' . ($student->nis ?? '-') . ' · Kelas: ' . ($student->schoolClass->name ?? 'belum ditempatkan')" />

<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <a href="{{ route('student.grades.index') }}"
       class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-primary/30 transition group">
        <div class="w-10 h-10 rounded-lg bg-primary-subtle flex items-center justify-center mb-3 group-hover:bg-primary group-hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <p class="font-medium text-gray-800">Nilai Saya</p>
    </a>
    <a href="{{ route('student.attendance.index') }}"
       class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-primary/30 transition group">
        <div class="w-10 h-10 rounded-lg bg-success-subtle flex items-center justify-center mb-3 group-hover:bg-success group-hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <p class="font-medium text-gray-800">Absensi Saya</p>
    </a>
    <a href="{{ route('student.invoices.index') }}"
       class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-primary/30 transition group">
        <div class="w-10 h-10 rounded-lg bg-secondary-subtle flex items-center justify-center mb-3 group-hover:bg-secondary group-hover:text-primary-dark transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a4 4 0 00-8 0v2M5 9h14l1 12H4L5 9z"/></svg>
        </div>
        <p class="font-medium text-gray-800">Tagihan & Pembayaran</p>
    </a>
</div>

<x-card title="Course yang Anda Ikuti">
    <div class="divide-y divide-gray-100 -mx-5">
        @forelse ($courses as $course)
            <div class="px-5 py-3">
                <p class="text-sm font-medium text-gray-800">{{ $course->title }}</p>
                <p class="text-xs text-gray-400">{{ $course->subject->name ?? '-' }} — Guru: {{ $course->teacher->user->name ?? '-' }}</p>
            </div>
        @empty
            <x-empty-state message="Belum join course apapun." />
        @endforelse
    </div>
</x-card>
@endsection
