@extends('layouts.app')
@section('title', 'Nilai Saya')
@section('content')
<x-page-header title="Nilai Saya" />

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[520px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Mata Pelajaran</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Tugas</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Kuis</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Ujian</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($grades as $grade)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Mata Pelajaran" class="px-4 py-3 font-medium text-gray-800">{{ $grade->course->subject->name ?? '-' }}</td>
                    <td data-label="Tugas" class="px-4 py-3 text-gray-600">{{ $grade->assignment_score ?? '-' }}</td>
                    <td data-label="Kuis" class="px-4 py-3 text-gray-600">{{ $grade->quiz_score ?? '-' }}</td>
                    <td data-label="Ujian" class="px-4 py-3 text-gray-600">{{ $grade->exam_score ?? '-' }}</td>
                    <td data-label="Nilai Akhir" class="px-4 py-3 font-semibold text-primary">{{ $grade->final_score ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5"><x-empty-state message="Belum ada nilai." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>
@endsection
