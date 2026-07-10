@extends('layouts.app')

@section('title', 'Isi Absensi')

@section('content')
<div class="flex items-center justify-between mb-2">
    <h1 class="text-xl font-semibold">
        Absensi — {{ $schedule->subject->name ?? '-' }} ({{ $schedule->schoolClass->name ?? '-' }})
    </h1>
    <a href="{{ route('teacher.attendance.index') }}" class="text-sm text-indigo-600 hover:underline">← Jadwal Saya</a>
</div>

<form method="GET" class="mb-4 text-sm">
    <label class="mr-2">Tanggal:</label>
    <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="border rounded px-2 py-1">
</form>

<form method="POST" action="{{ route('teacher.attendance.store', $schedule) }}">
    @csrf
    <input type="hidden" name="attendance_date" value="{{ $date }}">

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">NIS</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2 w-96">Status Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $i => $student)
                    @php $current = $existing->get($student->id)?->status ?? 'present'; @endphp
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $student->nis }}</td>
                        <td class="px-4 py-2">{{ $student->user->name ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <input type="hidden" name="statuses[{{ $i }}][student_id]" value="{{ $student->id }}">
                            <div class="flex gap-3 text-xs">
                                @foreach (['present' => 'Hadir', 'absent' => 'Alpa', 'sick' => 'Sakit', 'permission' => 'Izin'] as $val => $label)
                                    <label class="flex items-center gap-1">
                                        <input type="radio" name="statuses[{{ $i }}][status]" value="{{ $val }}"
                                               {{ $current === $val ? 'checked' : '' }}>
                                        {{ $label }}
                                    </label>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada murid di kelas ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($students->isNotEmpty())
        <button type="submit" class="mt-4 bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">
            Simpan Absensi
        </button>
    @endif
</form>
@endsection
