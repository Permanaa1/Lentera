@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')
<h1 class="text-xl font-semibold mb-6">Notifikasi</h1>

<div class="space-y-2">
    @forelse ($notifications as $n)
        <div @class([
            'bg-white p-4 rounded-lg shadow flex items-start justify-between',
            'border-l-4 border-indigo-500' => ! $n->is_read,
        ])>
            <div>
                <p @class(['font-medium', 'text-gray-500' => $n->is_read])>{{ $n->title }}</p>
                <p class="text-sm text-gray-600">{{ $n->message }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $n->created_at->diffForHumans() }}</p>
            </div>
            @unless ($n->is_read)
                <form method="POST" action="{{ route('notifications.read', $n) }}">
                    @csrf
                    <button class="text-xs text-indigo-600 hover:underline">Tandai dibaca</button>
                </form>
            @endunless
        </div>
    @empty
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-400">Belum ada notifikasi.</div>
    @endforelse
</div>

<div class="mt-4">{{ $notifications->links() }}</div>
@endsection
