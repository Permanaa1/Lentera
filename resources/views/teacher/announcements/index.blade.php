@extends('layouts.app')
@section('title', 'Pengumuman Course')
@section('content')
<x-page-header title="Pengumuman yang Saya Kirim" />

<div class="space-y-3">
    @forelse ($announcements as $a)
        <div class="bg-white p-4 sm:p-5 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-start justify-between gap-3">
                <p class="font-medium text-gray-800">{{ $a->title }}</p>
                <x-badge color="primary">{{ $a->course->title ?? '-' }}</x-badge>
            </div>
            <p class="text-sm text-gray-600 mt-1.5">{{ $a->content }}</p>
            <p class="text-xs text-gray-400 mt-3 pt-3 border-t border-gray-100">{{ $a->created_at->diffForHumans() }}</p>
        </div>
    @empty
        <x-card>
            <x-empty-state message="Belum ada pengumuman.">
                <x-slot:action>
                    <x-button href="{{ route('teacher.courses.index') }}" variant="primary">Buka Course Saya</x-button>
                </x-slot:action>
            </x-empty-state>
        </x-card>
    @endforelse
</div>

<div class="mt-4">{{ $announcements->links() }}</div>
@endsection
