@extends('layouts.admin')
@section('title', 'Jadwal Mingguan')
@section('admin-content')
<x-page-header title="Jadwal Mingguan" subtitle="Tampilan grid per kelas, lebih mudah dibaca dan cek bentrok visual."
    :back="route('admin.schedules.index')" backLabel="Tabel Jadwal" />

<form method="GET" class="mb-4">
    <select name="class_id" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2.5 min-h-[44px] text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
        @foreach ($classes as $class)
            <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
        @endforeach
    </select>
</form>

@if ($slots->isEmpty())
    <x-card>
        <x-empty-state message="Kelas ini belum punya jadwal.">
            <x-slot:action>
                <x-button href="{{ route('admin.schedules.create') }}" variant="primary">Tambah Jadwal</x-button>
            </x-slot:action>
        </x-empty-state>
    </x-card>
@else
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-x-auto">
        <table class="w-full text-sm border-collapse min-w-[700px]">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-3 py-3 border-b border-gray-100 text-left w-28 text-gray-600 font-semibold">Jam</th>
                    @foreach ($days as $day)
                        <th class="px-3 py-3 border-b border-gray-100 text-left text-gray-600 font-semibold min-w-[140px]">{{ $day }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($slots as $i => $slot)
                    <tr class="border-b border-gray-50 last:border-0">
                        <td class="px-3 py-3 align-top font-medium text-xs text-gray-500">
                            {{ substr($slot['start'], 0, 5) }}–{{ substr($slot['end'], 0, 5) }}
                        </td>
                        @foreach ($days as $day)
                            @php $cell = $grid[$i][$day] ?? null; @endphp
                            <td class="px-3 py-3 align-top {{ $cell ? 'bg-primary-subtle/30' : '' }}">
                                @if ($cell)
                                    <p class="font-medium text-primary text-sm">{{ $cell->subject->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">{{ $cell->teacher->user->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-400 mb-1">{{ $cell->room->code ?? '-' }}</p>
                                    <a href="{{ route('admin.schedules.edit', $cell) }}" class="text-xs text-primary hover:underline">Edit</a>
                                @else
                                    <span class="text-gray-300 text-xs">—</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
