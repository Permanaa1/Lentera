@extends('layouts.app')

@section('title', 'Pengumuman Course')

@section('content')
<h1 class="text-xl font-semibold mb-6">Pengumuman yang Saya Kirim</h1>

<div class="space-y-3">
    @forelse ($announcements as $a)
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <p class="font-medium">{{ $a->title }}</p>
                <span class="text-xs px-2 py-0.5 bg-gray-100 rounded">{{ $a->course->title ?? '-' }}</span>
            </div>
            <p class="text-sm text-gray-600 mt-1">{{ $a->content }}</p>
            <p class="text-xs text-gray-400 mt-3">{{ $a->created_at->diffForHumans() }}</p>
        </div>
    @empty
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-400">
            Belum ada pengumuman. Buka <a href="{{ route('teacher.courses.index') }}" class="text-indigo-600 hover:underline">Course Saya</a>
            untuk kirim pengumuman ke salah satu course.
        </div>
    @endforelse
</div>

<div class="mt-4">{{ $announcements->links() }}</div>
@endsection
