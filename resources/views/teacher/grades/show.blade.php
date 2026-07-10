@extends('layouts.app')

@section('title', 'Input Nilai')

@section('content')
<div class="flex items-center justify-between mb-2">
    <h1 class="text-xl font-semibold">Input Nilai — {{ $course->title }}</h1>
    <a href="{{ route('teacher.courses.index') }}" class="text-sm text-indigo-600 hover:underline">← Course Saya</a>
</div>
<p class="text-sm text-gray-500 mb-6">Nilai akhir dihitung otomatis: 40% tugas + 30% kuis + 30% ujian.</p>

<form method="POST" action="{{ route('teacher.grades.update', $course) }}">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">NIS</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2 w-28">Tugas (40%)</th>
                    <th class="px-4 py-2 w-28">Kuis (30%)</th>
                    <th class="px-4 py-2 w-28">Ujian (30%)</th>
                    <th class="px-4 py-2 w-24">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $i => $student)
                    @php $grade = $grades->get($student->id); @endphp
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $student->nis }}</td>
                        <td class="px-4 py-2">{{ $student->user->name ?? '-' }}</td>
                        <td class="px-2 py-2">
                            <input type="hidden" name="scores[{{ $i }}][student_id]" value="{{ $student->id }}">
                            <input type="number" step="0.01" min="0" max="100"
                                   name="scores[{{ $i }}][assignment_score]"
                                   value="{{ old("scores.$i.assignment_score", $grade->assignment_score ?? '') }}"
                                   class="w-24 border rounded px-2 py-1 text-sm">
                        </td>
                        <td class="px-2 py-2">
                            <input type="number" step="0.01" min="0" max="100"
                                   name="scores[{{ $i }}][quiz_score]"
                                   value="{{ old("scores.$i.quiz_score", $grade->quiz_score ?? '') }}"
                                   class="w-24 border rounded px-2 py-1 text-sm">
                        </td>
                        <td class="px-2 py-2">
                            <input type="number" step="0.01" min="0" max="100"
                                   name="scores[{{ $i }}][exam_score]"
                                   value="{{ old("scores.$i.exam_score", $grade->exam_score ?? '') }}"
                                   class="w-24 border rounded px-2 py-1 text-sm">
                        </td>
                        <td class="px-4 py-2 font-medium">{{ $grade->final_score ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada murid di kelas ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($students->isNotEmpty())
        <button type="submit" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">
            Simpan Nilai
        </button>
    @endif
</form>
@endsection
