@extends('layouts.app')

@section('title', 'Dashboard Wali Murid')

@section('content')
<x-page-header title="Dashboard Wali Murid" subtitle="Pantau perkembangan akademik anak Anda di sini.">
    <x-slot:actions>
        <x-button href="{{ route('parent.link.create') }}" variant="primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Hubungkan Anak
        </x-button>
    </x-slot:actions>
</x-page-header>

<x-card title="Anak yang Terhubung">
    <div class="divide-y divide-gray-100 -mx-5">
        @forelse ($students as $student)
            <div class="px-5 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-primary-subtle text-primary flex items-center justify-center text-sm font-semibold shrink-0">
                        {{ strtoupper(substr($student->user->name ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $student->user->name ?? '-' }}</p>
                        <p class="text-xs text-gray-400">NIS: {{ $student->nis }} · {{ $student->schoolClass->name ?? '-' }}</p>
                    </div>
                </div>
                <x-button href="{{ route('parent.students.show', $student) }}" variant="outline" class="shrink-0">
                    Lihat Detail
                </x-button>
            </div>
        @empty
            <x-empty-state message="Belum ada anak yang terhubung. Klik &quot;Hubungkan Anak&quot; di atas dan masukkan kode dari sekolah.">
                <x-slot:action>
                    <x-button href="{{ route('parent.link.create') }}" variant="primary">Hubungkan Sekarang</x-button>
                </x-slot:action>
            </x-empty-state>
        @endforelse
    </div>
</x-card>
@endsection
