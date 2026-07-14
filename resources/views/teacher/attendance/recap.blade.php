@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">
        Absensi Tanggal Ini — {{ $schedule->subject->name ?? '-' }} ({{ $schedule->schoolClass->name ?? '-' }})
        <span class="text-sm font-normal text-gray-500">{{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}</span>
    </h1>
    <div class="flex gap-3 text-sm">
        <a href="{{ route('teacher.attendance.create', ['schedule' => $schedule, 'date' => $date, 'edit' => 1]) }}"
           class="text-indigo-600 hover:underline">Edit Absensi Ini</a>
        <a href="{{ route('teacher.attendance.class-recap', $schedule) }}" class="text-gray-600 hover:underline">
            Rekap Keseluruhan
        </a>
    </div>
</div>

<p class="text-xs text-gray-400 mb-4">
    Data ini sudah tersimpan. Untuk mengubahnya, klik "Edit Absensi Ini" di atas -- ini mencegah perubahan tidak sengaja.
</p>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">NIS</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $a)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $a->student->nis ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $a->student->user->name ?? '-' }}</td>
                    <td class="px-4 py-2">
                        @php
                            $labels = ['present' => 'Hadir', 'absent' => 'Alpa', 'sick' => 'Sakit', 'permission' => 'Izin'];
                            $colors = [
                                'present' => 'bg-green-100 text-green-800',
                                'absent' => 'bg-red-100 text-red-800',
                                'sick' => 'bg-yellow-100 text-yellow-800',
                                'permission' => 'bg-blue-100 text-blue-800',
                            ];
                        @endphp
                        <span class="px-2 py-0.5 rounded text-xs {{ $colors[$a->status] }}">{{ $labels[$a->status] }}</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada absensi tanggal ini.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
