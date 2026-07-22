@extends('layouts.app')
@section('title', 'Notifikasi')
@section('content')
<x-page-header title="Notifikasi" />

<div class="space-y-2">
    @forelse ($notifications as $n)
        <div @class([
            'bg-white p-4 rounded-xl shadow-sm border flex items-start justify-between gap-3',
            'border-primary/30 border-l-4' => ! $n->is_read,
            'border-gray-100' => $n->is_read,
        ])>
            <div class="flex items-start gap-3">
                <div @class([
                    'w-9 h-9 rounded-full flex items-center justify-center shrink-0',
                    'bg-primary-subtle text-primary' => ! $n->is_read,
                    'bg-gray-100 text-gray-400' => $n->is_read,
                ])>
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div>
                    <p @class(['font-medium text-sm', 'text-gray-800' => ! $n->is_read, 'text-gray-500' => $n->is_read])>{{ $n->title }}</p>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $n->message }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $n->created_at->diffForHumans() }}</p>
                </div>
            </div>
            @unless ($n->is_read)
                <form method="POST" action="{{ route('notifications.read', $n) }}" class="shrink-0">
                    @csrf
                    <button class="text-xs text-primary hover:underline whitespace-nowrap">Tandai dibaca</button>
                </form>
            @endunless
        </div>
    @empty
        <x-card><x-empty-state message="Belum ada notifikasi." /></x-card>
    @endforelse
</div>

<div class="mt-4">{{ $notifications->links() }}</div>
@endsection
