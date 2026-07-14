@extends('layouts.app')

@section('title', 'Dashboard Wali Murid')

@section('content')
<div class="flex items-center justify-between mb-2">
    <h1 class="text-xl font-semibold">Dashboard Wali Murid</h1>
    <a href="{{ route('parent.link.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">+ Hubungkan Anak</a>
</div>
<p class="text-sm text-gray-500 mb-6">Halo, {{ auth()->user()->name }}</p>

<div class="bg-white p-4 rounded-lg shadow">
    <p class="text-sm font-medium mb-3">Anak yang terhubung ({{ $students->count() }})</p>

    @forelse ($students as $student)
        <div class="border-t py-2 text-sm flex justify-between items-center">
            <span>{{ $student->user->name ?? '-' }} — NIS: {{ $student->nis }} (Kelas: {{ $student->schoolClass->name ?? '-' }})</span>
            <a href="{{ route('parent.students.show', $student) }}" class="text-indigo-600 hover:underline text-xs">Lihat Detail</a>
        </div>
    @empty
        <p class="text-gray-400 italic text-sm">
            Belum ada anak yang terhubung. Klik "+ Hubungkan Anak" di atas dan masukkan kode dari sekolah.
        </p>
    @endforelse
</div>
@endsection
