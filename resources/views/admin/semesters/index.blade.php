@extends('layouts.admin')

@section('title', 'Semester')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Semester</h1>
    <a href="{{ route('admin.semesters.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">+ Tambah</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Tahun Ajaran</th>
                <th class="px-4 py-2">Periode</th>
                <th class="px-4 py-2 w-40">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($semesters as $semester)
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium">{{ $semester->name }}</td>
                    <td class="px-4 py-2">{{ $semester->academicYear->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $semester->start_date->format('d M Y') }} — {{ $semester->end_date->format('d M Y') }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('admin.semesters.edit', $semester) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('admin.semesters.destroy', $semester) }}" class="inline"
                              onsubmit="return confirm('Yakin hapus semester ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $semesters->links() }}</div>
@endsection
