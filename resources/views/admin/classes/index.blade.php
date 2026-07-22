@extends('layouts.admin')
@section('title', 'Kelas (Rombel)')
@section('admin-content')
<x-page-header title="Kelas (Rombel Akademik)" subtitle="Rombongan belajar per jurusan dan tahun ajaran."
    :breadcrumbs="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Kelas']]">
    <x-slot:actions>
        <x-button href="{{ route('admin.classes.create') }}" variant="primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah
        </x-button>
    </x-slot:actions>
</x-page-header>

<form method="GET" class="flex flex-wrap items-center gap-2 mb-4">
    <x-search-input placeholder="Cari nama kelas..." />
    <x-button type="submit" variant="outline">Cari</x-button>
</form>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[640px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Nama Kelas</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Jurusan</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Tahun Ajaran</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Wali Kelas</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Murid</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-28 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($classes as $class)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Nama Kelas" class="px-4 py-3 font-medium text-gray-800">{{ $class->name }}</td>
                    <td data-label="Jurusan" class="px-4 py-3 text-gray-600">{{ $class->department->name ?? '-' }}</td>
                    <td data-label="Tahun Ajaran" class="px-4 py-3 text-gray-600">{{ $class->academicYear->name ?? '-' }}</td>
                    <td data-label="Wali Kelas" class="px-4 py-3 text-gray-600">{{ $class->homeroomTeacher->user->name ?? '-' }}</td>
                    <td data-label="Murid" class="px-4 py-3"><x-badge color="primary">{{ $class->students_count }}</x-badge></td>
                    <td data-label="Aksi" class="px-4 py-3">
                        <div class="flex items-center gap-1 justify-end">
                            <x-icon-button variant="edit" label="Edit" :href="route('admin.classes.edit', $class)" />
                            <form method="POST" action="{{ route('admin.classes.destroy', $class) }}"
                                  onsubmit="return confirm('Yakin hapus kelas ini?')">
                                @csrf @method('DELETE')
                                <x-icon-button variant="delete" label="Hapus" />
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6"><x-empty-state message="Belum ada kelas." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>
<div class="mt-4">{{ $classes->links() }}</div>
@endsection
