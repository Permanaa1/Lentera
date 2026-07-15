@extends('layouts.app')

@section('title', 'Isi Absensi')

@section('content')
<x-page-header
    title="Isi Absensi"
    :subtitle="($schedule->subject->name ?? '-') . ' — ' . ($schedule->schoolClass->name ?? '-')"
    :back="route('teacher.attendance.index')"
    backLabel="Jadwal Saya" />

@if ($existing->isNotEmpty())
    <div class="bg-warning-subtle border-l-4 border-secondary text-yellow-800 rounded-r-lg px-4 py-3 text-sm mb-4">
        Anda sedang <strong>mengubah</strong> absensi yang sudah tersimpan untuk tanggal ini. Perubahan akan menimpa data lama.
    </div>
@endif

<form method="GET" class="mb-4 text-sm flex items-center gap-2">
    <label class="text-gray-600">Tanggal:</label>
    <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()"
           class="border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-primary/20">
</form>

<form method="POST" action="{{ route('teacher.attendance.store', $schedule) }}">
    @csrf
    <input type="hidden" name="attendance_date" value="{{ $date }}">

    @php
        $statusOptions = ['present' => 'Hadir', 'absent' => 'Alpa', 'sick' => 'Sakit', 'permission' => 'Izin'];
        $statusStyles = [
            'present' => 'peer-checked:bg-success peer-checked:border-success peer-checked:text-white',
            'absent' => 'peer-checked:bg-danger peer-checked:border-danger peer-checked:text-white',
            'sick' => 'peer-checked:bg-secondary peer-checked:border-secondary peer-checked:text-primary-dark',
            'permission' => 'peer-checked:bg-info peer-checked:border-info peer-checked:text-white',
        ];
    @endphp

    <div class="space-y-2">
        @forelse ($students as $i => $student)
            @php $current = $existing->get($student->id)?->status ?? 'present'; @endphp
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-4 py-3 flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                <input type="hidden" name="statuses[{{ $i }}][student_id]" value="{{ $student->id }}">

                <div class="sm:w-56 shrink-0">
                    <p class="font-medium text-gray-800 text-sm">{{ $student->user->name ?? '-' }}</p>
                    <p class="text-xs text-gray-400">NIS: {{ $student->nis }}</p>
                </div>

                <div class="flex flex-wrap gap-1.5">
                    @foreach ($statusOptions as $val => $label)
                        <label class="cursor-pointer select-none">
                            <input type="radio" name="statuses[{{ $i }}][status]" value="{{ $val }}"
                                   class="peer sr-only" {{ $current === $val ? 'checked' : '' }}>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-medium
                                         border border-gray-300 text-gray-500 transition {{ $statusStyles[$val] }}">
                                {{ $label }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        @empty
            <x-empty-state message="Belum ada murid di kelas ini." />
        @endforelse
    </div>

    @if ($students->isNotEmpty())
        <x-button type="submit" variant="primary" class="mt-4">Simpan Absensi</x-button>
    @endif
</form>
@endsection
