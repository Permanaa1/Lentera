@extends('layouts.app')

@section('title', 'Dashboard Wali Murid')

@section('content')
<h1 class="text-xl font-semibold mb-2">Dashboard Wali Murid</h1>
<p class="text-sm text-gray-500 mb-6">Halo, {{ auth()->user()->name }}</p>

<div class="bg-white p-4 rounded-lg shadow">
    <p class="text-sm font-medium mb-3">Anak yang terhubung ({{ $students->count() }})</p>

    @forelse ($students as $student)
        <div class="border-t py-2 text-sm">
            {{ $student->user->name ?? '-' }} — NIS: {{ $student->nis }}
            (Kelas: {{ $student->schoolClass->name ?? '-' }})
        </div>
    @empty
        <p class="text-gray-400 italic text-sm">Belum ada anak yang terhubung ke akun ini. (Perlu linkStudent() manual dulu lewat tinker/admin, fitur UI-nya belum ada sampai fase ini)</p>
    @endforelse
</div>
@endsection
