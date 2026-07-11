@extends('layouts.admin')

@section('title', 'Pengumuman')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Pengumuman Akademik</h1>
    <a href="{{ route('admin.announcements.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">+ Buat Pengumuman</a>
</div>

<div class="space-y-3">
    @forelse ($announcements as $a)
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="flex items-center justify-between">
                <p class="font-medium">{{ $a->title }}</p>
                <span class="text-xs px-2 py-0.5 bg-gray-100 rounded uppercase">{{ $a->target_role }}</span>
            </div>
            <p class="text-sm text-gray-600 mt-1">{{ $a->content }}</p>
            <div class="flex items-center justify-between mt-3">
                <p class="text-xs text-gray-400">
                    {{ $a->creator->name ?? '-' }} · {{ $a->created_at->diffForHumans() }}
                </p>
                <form method="POST" action="{{ route('admin.announcements.destroy', $a) }}"
                      onsubmit="return confirm('Hapus pengumuman ini?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:underline text-xs">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-400">Belum ada pengumuman.</div>
    @endforelse
</div>

<div class="mt-4">{{ $announcements->links() }}</div>
@endsection
