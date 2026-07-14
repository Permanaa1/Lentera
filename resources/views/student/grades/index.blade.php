@extends('layouts.app')

@section('title', 'Nilai Saya')

@section('content')
<h1 class="text-xl font-semibold mb-6">Nilai Saya</h1>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Mata Pelajaran</th>
                <th class="px-4 py-2">Tugas</th>
                <th class="px-4 py-2">Kuis</th>
                <th class="px-4 py-2">Ujian</th>
                <th class="px-4 py-2">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($grades as $grade)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $grade->course->subject->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $grade->assignment_score ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $grade->quiz_score ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $grade->exam_score ?? '-' }}</td>
                    <td class="px-4 py-2 font-medium">{{ $grade->final_score ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada nilai.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
