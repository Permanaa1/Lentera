@extends('layouts.admin')

@section('title', 'Ruang Kelas')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Ruang Kelas</h1>
    <a href="{{ route('admin.rooms.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">+ Tambah</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Kode</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Kapasitas</th>
                <th class="px-4 py-2">Dipakai di Jadwal</th>
                <th class="px-4 py-2 w-40">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rooms as $room)
                <tr class="border-t">
                    <td class="px-4 py-2 font-mono">{{ $room->code }}</td>
                    <td class="px-4 py-2">{{ $room->name }}</td>
                    <td class="px-4 py-2">{{ $room->capacity ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $room->schedules_count }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admin.rooms.edit', $room) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}" class="inline"
                              onsubmit="return confirm('Yakin hapus ruang ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $rooms->links() }}</div>
@endsection
