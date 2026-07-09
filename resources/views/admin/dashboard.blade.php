@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<h1 class="text-xl font-semibold mb-6">Dashboard Admin</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-4 rounded-lg shadow">
        <p class="text-xs text-gray-500 uppercase">Total User</p>
        <p class="text-2xl font-bold">{{ $stats['total_users'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <p class="text-xs text-gray-500 uppercase">Guru</p>
        <p class="text-2xl font-bold">{{ $stats['total_teachers'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <p class="text-xs text-gray-500 uppercase">Murid</p>
        <p class="text-2xl font-bold">{{ $stats['total_students'] }}</p>
    </div>
    <div class="bg-white p-4 rounded-lg shadow">
        <p class="text-xs text-gray-500 uppercase">Course</p>
        <p class="text-2xl font-bold">{{ $stats['total_courses'] }}</p>
    </div>
</div>

@if ($stats['pending_teachers'] > 0)
    <div class="mb-6 px-4 py-3 rounded bg-yellow-100 text-yellow-800 text-sm flex items-center justify-between">
        <span>Ada {{ $stats['pending_teachers'] }} akun guru menunggu persetujuan.</span>
        <a href="{{ route('admin.users.index', ['role' => 'teacher', 'status' => 'pending']) }}"
           class="font-medium underline">Lihat & Approve</a>
    </div>
@endif

<div class="bg-white p-4 rounded-lg shadow mb-6">
    <p class="text-xs text-gray-500 uppercase mb-1">Tahun Ajaran Aktif</p>
    @if ($stats['active_academic_year'])
        <p class="font-medium">{{ $stats['active_academic_year']->name }}</p>
    @else
        <p class="text-gray-400 italic">Belum ada tahun ajaran aktif.</p>
    @endif
</div>

<a href="{{ route('admin.users.index') }}" class="text-indigo-600 hover:underline text-sm">
    → Kelola Pengguna
</a>
@endsection
