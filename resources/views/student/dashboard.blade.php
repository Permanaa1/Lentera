@extends('layouts.app')

@section('title', 'Dashboard Murid')

@section('content')
<h1 class="text-xl font-semibold mb-2">Dashboard Murid</h1>
<p class="text-sm text-gray-500 mb-6">
    Halo, {{ auth()->user()->name }} — NIS: {{ $student->nis ?? '-' }}
    (Kelas: {{ $student->schoolClass->name ?? 'belum ditempatkan' }})
</p>

<div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6 text-sm">
    <a href="{{ route('student.grades.index') }}" class="bg-white p-4 rounded-lg shadow hover:bg-gray-50">
        <p class="font-medium">Nilai Saya</p>
    </a>
    <a href="{{ route('student.attendance.index') }}" class="bg-white p-4 rounded-lg shadow hover:bg-gray-50">
        <p class="font-medium">Absensi Saya</p>
    </a>
    <a href="{{ route('student.invoices.index') }}" class="bg-white p-4 rounded-lg shadow hover:bg-gray-50">
        <p class="font-medium">Tagihan & Pembayaran</p>
    </a>
</div>

<div class="bg-white p-4 rounded-lg shadow">
    <p class="text-sm font-medium mb-3">Course yang Anda ikuti ({{ $courses->count() }})</p>

    @forelse ($courses as $course)
        <div class="border-t py-2 text-sm">
            {{ $course->title }} — {{ $course->subject->name ?? '-' }}
            (Guru: {{ $course->teacher->user->name ?? '-' }})
        </div>
    @empty
        <p class="text-gray-400 italic text-sm">Belum join course apapun. (Fitur join-by-code masuk di Fase 5)</p>
    @endforelse
</div>
@endsection
