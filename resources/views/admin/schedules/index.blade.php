@extends('layouts.admin')

@section('title', 'Jadwal')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Jadwal Pelajaran</h1>
    <a href="{{ route('admin.schedules.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">+ Tambah</a>
</div>

<form method="GET" class="mb-4 text-sm">
    <select name="class_id" class="border rounded px-2 py-1" onchange="this.form.submit()">
        <option value="">Semua Kelas</option>
        @foreach ($classes as $class)
            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                {{ $class->name }}
            </option>
        @endforeach
    </select>
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Hari</th>
                <th class="px-4 py-2">Jam</th>
                <th class="px-4 py-2">Kelas</th>
                <th class="px-4 py-2">Mata Pelajaran</th>
                <th class="px-4 py-2">Guru</th>
                <th class="px-4 py-2">Ruang</th>
                <th class="px-4 py-2 w-32">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($schedules as $schedule)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $schedule->day }}</td>
                    <td class="px-4 py-2">{{ substr($schedule->start_time, 0, 5) }}–{{ substr($schedule->end_time, 0, 5) }}</td>
                    <td class="px-4 py-2">{{ $schedule->schoolClass->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $schedule->subject->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $schedule->teacher->user->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $schedule->room->code ?? '-' }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admin.schedules.edit', $schedule) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" class="inline"
                              onsubmit="return confirm('Yakin hapus jadwal ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-6 text-center text-gray-400">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $schedules->links() }}</div>
@endsection
