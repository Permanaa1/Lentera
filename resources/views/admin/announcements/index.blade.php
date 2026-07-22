@extends('layouts.admin')
@section('title', 'Pengumuman')
@section('admin-content')
<x-page-header title="Pengumuman Akademik" subtitle="Broadcast informasi ke role tertentu atau semua pengguna."
    :breadcrumbs="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Pengumuman']]">
    <x-slot:actions>
        <x-button href="{{ route('admin.announcements.create') }}" variant="primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Pengumuman
        </x-button>
    </x-slot:actions>
</x-page-header>

<div class="space-y-3">
    @forelse ($announcements as $a)
        <div class="bg-white p-4 sm:p-5 rounded-xl shadow-sm border border-gray-100">
            <div class="flex items-start justify-between gap-3">
                <p class="font-medium text-gray-800">{{ $a->title }}</p>
                <x-badge color="primary">{{ $a->target_role }}</x-badge>
            </div>
            <p class="text-sm text-gray-600 mt-1.5">{{ $a->content }}</p>
            <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                <p class="text-xs text-gray-400">{{ $a->creator->name ?? '-' }} · {{ $a->created_at->diffForHumans() }}</p>
                <form method="POST" action="{{ route('admin.announcements.destroy', $a) }}"
                      onsubmit="return confirm('Hapus pengumuman ini?')">
                    @csrf @method('DELETE')
                    <button class="text-danger hover:underline text-xs font-medium">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <x-card><x-empty-state message="Belum ada pengumuman." /></x-card>
    @endforelse
</div>

<div class="mt-4">{{ $announcements->links() }}</div>
@endsection
