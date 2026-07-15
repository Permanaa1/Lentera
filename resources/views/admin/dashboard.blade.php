@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('admin-content')
<h1 class="text-xl font-semibold text-gray-800 mb-6">Dashboard Admin</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 mb-6">
    <x-card>
        <p class="text-xs text-gray-400 uppercase tracking-wide">Total User</p>
        <p class="text-2xl font-bold text-primary mt-1">{{ $stats['total_users'] }}</p>
    </x-card>
    <x-card>
        <p class="text-xs text-gray-400 uppercase tracking-wide">Guru</p>
        <p class="text-2xl font-bold text-primary mt-1">{{ $stats['total_teachers'] }}</p>
    </x-card>
    <x-card>
        <p class="text-xs text-gray-400 uppercase tracking-wide">Murid</p>
        <p class="text-2xl font-bold text-primary mt-1">{{ $stats['total_students'] }}</p>
    </x-card>
    <x-card>
        <p class="text-xs text-gray-400 uppercase tracking-wide">Course</p>
        <p class="text-2xl font-bold text-primary mt-1">{{ $stats['total_courses'] }}</p>
    </x-card>
</div>

@if ($stats['pending_teachers'] > 0)
    <x-alert type="warning" class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <span>Ada {{ $stats['pending_teachers'] }} akun guru menunggu persetujuan.</span>
            <a href="{{ route('admin.users.index', ['role' => 'teacher', 'status' => 'pending']) }}"
               class="font-medium underline shrink-0">Lihat & Approve</a>
        </div>
    </x-alert>
@endif

<x-card title="Tahun Ajaran Aktif">
    @if ($stats['active_academic_year'])
        <p class="font-medium text-gray-700">{{ $stats['active_academic_year']->name }}</p>
    @else
        <p class="text-gray-400 italic text-sm">
            Belum ada tahun ajaran aktif.
            <a href="{{ route('admin.academic-years.index') }}" class="text-primary hover:underline">Atur di sini</a>.
        </p>
    @endif
</x-card>
@endsection
