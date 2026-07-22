@extends('layouts.app')
@section('title', 'Rapor Murid')
@section('content')
<x-page-header title="Rapor Murid" subtitle="Khusus untuk guru yang berstatus wali kelas." />

@forelse ($homeroomClasses as $class)
    <x-card :title="$class->name . ' (' . $class->students_count . ' murid)'" class="mb-4">
        <div class="divide-y divide-gray-100 -mx-5">
            @foreach ($class->students as $student)
                <div class="px-5 py-3 flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $student->user->name ?? '-' }}</p>
                        <p class="text-xs text-gray-400">NIS: {{ $student->nis }}</p>
                    </div>
                    <x-button href="{{ route('teacher.report-card.show', [$class, $student]) }}" variant="outline">
                        Lihat Rapor
                    </x-button>
                </div>
            @endforeach
        </div>
    </x-card>
@empty
    <x-card>
        <x-empty-state message="Anda bukan wali kelas manapun. Fitur ini cuma untuk guru yang ditugaskan sebagai wali kelas (diatur admin di menu Kelas)." />
    </x-card>
@endforelse
@endsection
