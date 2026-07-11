@extends('layouts.admin')

@section('title', 'Kelola Murid')

@section('admin-content')
<h1 class="text-xl font-semibold mb-6">Kelola Murid & Penempatan Kelas</h1>

<form method="GET" class="flex gap-3 mb-4 text-sm">
    <select name="class_id" class="border rounded px-2 py-1" onchange="this.form.submit()">
        <option value="">Semua Kelas</option>
        @foreach ($classes as $class)
            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
        @endforeach
    </select>
    <label class="flex items-center gap-1">
        <input type="checkbox" name="unassigned" value="1" {{ request('unassigned') ? 'checked' : '' }} onchange="this.form.submit()">
        Belum punya kelas
    </label>
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">NIS</th>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Kelas</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2 w-24">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $student)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $student->nis }}</td>
                    <td class="px-4 py-2">{{ $student->user->name ?? '-' }}</td>
                    <td class="px-4 py-2">
                        @if ($student->schoolClass)
                            {{ $student->schoolClass->name }}
                        @else
                            <span class="text-red-500 text-xs">Belum ada kelas</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $student->academic_status }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.students.edit', $student) }}" class="text-indigo-600 hover:underline">Edit</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $students->links() }}</div>
@endsection
