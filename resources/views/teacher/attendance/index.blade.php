@extends('layouts.app')
@section('title', 'Kelola Absensi')
@section('content')
<x-page-header title="Jadwal Mengajar Saya" subtitle="Pilih jadwal untuk isi absensi hari ini, atau lihat rekap keseluruhan." />

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[560px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Hari</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Jam</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Kelas</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Mata Pelajaran</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-56 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($schedules as $schedule)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Hari" class="px-4 py-3 text-gray-600">{{ $schedule->day }}</td>
                    <td data-label="Jam" class="px-4 py-3 text-gray-600">{{ substr($schedule->start_time, 0, 5) }}–{{ substr($schedule->end_time, 0, 5) }}</td>
                    <td data-label="Kelas" class="px-4 py-3 font-medium text-gray-800">{{ $schedule->schoolClass->name ?? '-' }}</td>
                    <td data-label="Mata Pelajaran" class="px-4 py-3 text-gray-600">{{ $schedule->subject->name ?? '-' }}</td>
                    <td data-label="Aksi" class="px-4 py-3">
                        <div class="flex items-center gap-3 justify-end flex-wrap">
                            <a href="{{ route('teacher.attendance.create', $schedule) }}" class="text-primary hover:underline text-sm font-medium">Isi Hari Ini</a>
                            <a href="{{ route('teacher.attendance.class-recap', $schedule) }}" class="text-gray-500 hover:underline text-sm font-medium">Rekap</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5"><x-empty-state message="Belum ada jadwal mengajar." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>
@endsection
