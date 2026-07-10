@extends('layouts.app')

@section('title', 'Rapor Murid')

@section('content')
<h1 class="text-xl font-semibold mb-6">Rapor Murid (Kelas Perwalian)</h1>

@forelse ($homeroomClasses as $class)
    <div class="bg-white rounded-lg shadow p-4 mb-4">
        <p class="font-medium mb-3">{{ $class->name }} ({{ $class->students_count }} murid)</p>
        <a href="{{ route('teacher.report-card.index') }}#class-{{ $class->id }}" class="hidden"></a>
        <div id="class-{{ $class->id }}">
            @foreach ($class->students as $student)
                <div class="flex items-center justify-between border-t py-2 text-sm">
                    <span>{{ $student->nis }} — {{ $student->user->name ?? '-' }}</span>
                    <a href="{{ route('teacher.report-card.show', [$class, $student]) }}" class="text-indigo-600 hover:underline">
                        Lihat Rapor
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@empty
    <div class="bg-white rounded-lg shadow p-6 text-center text-gray-400">
        Anda bukan wali kelas manapun. Fitur ini cuma untuk guru yang ditugaskan sebagai wali kelas
        (diatur admin di menu Kelas).
    </div>
@endforelse
@endsection
