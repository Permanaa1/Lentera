@extends('layouts.app')

@section('title', 'Input Nilai')

@section('content')
<x-page-header title="Input Nilai" :subtitle="$course->title" :back="route('teacher.courses.index')" backLabel="Course Saya" />

<div class="bg-info-subtle border-l-4 border-info text-info rounded-r-lg px-4 py-3 text-sm mb-4">
    Nilai akhir dihitung otomatis: 40% tugas + 30% kuis + 30% ujian.
</div>

<form method="POST" action="{{ route('teacher.grades.update', $course) }}">
    @csrf
    @method('PUT')

    <x-table-wrapper>
        <table class="responsive-table w-full text-sm min-w-[640px]">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600">NIS</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                    <th class="px-4 py-3 font-semibold text-gray-600 w-28">Tugas (40%)</th>
                    <th class="px-4 py-3 font-semibold text-gray-600 w-28">Kuis (30%)</th>
                    <th class="px-4 py-3 font-semibold text-gray-600 w-28">Ujian (30%)</th>
                    <th class="px-4 py-3 font-semibold text-gray-600 w-24">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($students as $i => $student)
                    @php $grade = $grades->get($student->id); @endphp
                    <tr class="hover:bg-surface/60 transition">
                        <td data-label="NIS" class="px-4 py-3 text-gray-500">{{ $student->nis }}</td>
                        <td data-label="Nama" class="px-4 py-3 font-medium text-gray-800">{{ $student->user->name ?? '-' }}</td>
                        <td data-label="Tugas (40%)" class="px-4 py-2">
                            <input type="hidden" name="scores[{{ $i }}][student_id]" value="{{ $student->id }}">
                            <input type="number" step="0.01" min="0" max="100"
                                   name="scores[{{ $i }}][assignment_score]"
                                   value="{{ old("scores.$i.assignment_score", $grade->assignment_score ?? '') }}"
                                   class="w-20 border border-gray-300 rounded-lg px-2 py-1.5 text-sm text-right
                                          focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        </td>
                        <td data-label="Kuis (30%)" class="px-4 py-2">
                            <input type="number" step="0.01" min="0" max="100"
                                   name="scores[{{ $i }}][quiz_score]"
                                   value="{{ old("scores.$i.quiz_score", $grade->quiz_score ?? '') }}"
                                   class="w-20 border border-gray-300 rounded-lg px-2 py-1.5 text-sm text-right
                                          focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        </td>
                        <td data-label="Ujian (30%)" class="px-4 py-2">
                            <input type="number" step="0.01" min="0" max="100"
                                   name="scores[{{ $i }}][exam_score]"
                                   value="{{ old("scores.$i.exam_score", $grade->exam_score ?? '') }}"
                                   class="w-20 border border-gray-300 rounded-lg px-2 py-1.5 text-sm text-right
                                          focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
                        </td>
                        <td data-label="Nilai Akhir" class="px-4 py-3">
                            <span class="font-semibold text-primary">{{ $grade->final_score ?? '—' }}</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6"><x-empty-state message="Belum ada murid di kelas ini." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-table-wrapper>

    @if ($students->isNotEmpty())
        <x-button type="submit" variant="primary" class="mt-4">Simpan Nilai</x-button>
    @endif
</form>
@endsection
