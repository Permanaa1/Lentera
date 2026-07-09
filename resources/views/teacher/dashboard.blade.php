@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
<h1 class="text-xl font-semibold mb-2">Dashboard Guru</h1>
<p class="text-sm text-gray-500 mb-6">
    Halo, {{ auth()->user()->name }} — NIP: {{ $teacher->nip ?? '-' }}
</p>

<div class="bg-white p-4 rounded-lg shadow">
    <p class="text-sm font-medium mb-3">Course yang Anda ampu ({{ $courses->count() }})</p>

    @forelse ($courses as $course)
        <div class="border-t py-2 text-sm flex justify-between">
            <span>{{ $course->title }} — {{ $course->subject->name ?? '-' }} ({{ $course->schoolClass->name ?? '-' }})</span>
            <span class="text-gray-400 text-xs">kode: {{ $course->class_code }}</span>
        </div>
    @empty
        <p class="text-gray-400 italic text-sm">Belum ada course. (Wajar di checkpoint Fase 1-3, fitur bikin course baru masuk di Fase 5)</p>
    @endforelse
</div>
@endsection
