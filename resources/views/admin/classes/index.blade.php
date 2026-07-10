@extends('layouts.admin')

@section('title', 'Kelas (Rombel)')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Kelas (Rombel Akademik)</h1>
    <a href="{{ route('admin.classes.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">+ Tambah</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Nama Kelas</th>
                <th class="px-4 py-2">Jurusan</th>
                <th class="px-4 py-2">Tahun Ajaran</th>
                <th class="px-4 py-2">Wali Kelas</th>
                <th class="px-4 py-2">Jml Murid</th>
                <th class="px-4 py-2 w-40">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($classes as $class)
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium">{{ $class->name }}</td>
                    <td class="px-4 py-2">{{ $class->department->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $class->academicYear->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $class->homeroomTeacher->user->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $class->students_count }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admin.classes.edit', $class) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" class="inline"
                              onsubmit="return confirm('Yakin hapus kelas ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-6 text-center text-gray-400">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $classes->links() }}</div>
@endsection
