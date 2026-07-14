@extends('layouts.admin')

@section('title', 'Jadwal Mingguan')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Jadwal Mingguan</h1>
    <a href="{{ route('admin.schedules.index') }}" class="text-sm text-indigo-600 hover:underline">Lihat sebagai Tabel</a>
</div>

<form method="GET" class="mb-4 text-sm">
    <select name="class_id" class="border rounded px-2 py-1" onchange="this.form.submit()">
        @foreach ($classes as $class)
            <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
        @endforeach
    </select>
</form>

@if ($slots->isEmpty())
    <div class="bg-white p-6 rounded-lg shadow text-center text-gray-400">
        Kelas ini belum punya jadwal.
        <a href="{{ route('admin.schedules.create') }}" class="text-indigo-600 hover:underline">Tambah jadwal</a>.
    </div>
@else
    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-3 py-2 border text-left w-28">Jam</th>
                    @foreach ($days as $day)
                        <th class="px-3 py-2 border text-left min-w-[140px]">{{ $day }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($slots as $i => $slot)
                    <tr>
                        <td class="px-3 py-2 border align-top font-medium text-xs text-gray-500">
                            {{ substr($slot['start'], 0, 5) }}–{{ substr($slot['end'], 0, 5) }}
                        </td>
                        @foreach ($days as $day)
                            @php $cell = $grid[$i][$day] ?? null; @endphp
                            <td class="px-3 py-2 border align-top {{ $cell ? 'bg-indigo-50' : '' }}">
                                @if ($cell)
                                    <p class="font-medium text-indigo-800">{{ $cell->subject->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">{{ $cell->teacher->user->name ?? '-' }}</p>
                                    <p class="text-xs text-gray-400">{{ $cell->room->code ?? '-' }}</p>
                                    <a href="{{ route('admin.schedules.edit', $cell) }}" class="text-xs text-indigo-600 hover:underline">Edit</a>
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
