@extends('layouts.admin')
@section('title', 'Jurusan')
@section('admin-content')
<x-page-header title="Jurusan" subtitle="Konsentrasi keahlian yang tersedia di sekolah."
    :breadcrumbs="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Jurusan']]">
    <x-slot:actions>
        <x-button href="{{ route('admin.departments.create') }}" variant="primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah
        </x-button>
    </x-slot:actions>
</x-page-header>

<form method="GET" class="flex flex-wrap items-center gap-2 mb-4">
    <x-search-input placeholder="Cari kode/nama jurusan..." />
    <x-button type="submit" variant="outline">Cari</x-button>
</form>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[480px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Kode</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Jml Kelas</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-28 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($departments as $dept)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Kode" class="px-4 py-3 font-mono text-gray-600">{{ $dept->code }}</td>
                    <td data-label="Nama" class="px-4 py-3 font-medium text-gray-800">{{ $dept->name }}</td>
                    <td data-label="Jml Kelas" class="px-4 py-3"><x-badge color="primary">{{ $dept->classes_count }}</x-badge></td>
                    <td data-label="Aksi" class="px-4 py-3">
                        <div class="flex items-center gap-1 justify-end">
                            <x-icon-button variant="edit" label="Edit" :href="route('admin.departments.edit', $dept)" />
                            <form method="POST" action="{{ route('admin.departments.destroy', $dept) }}"
                                  onsubmit="return confirm('Yakin hapus jurusan ini?')">
                                @csrf @method('DELETE')
                                <x-icon-button variant="delete" label="Hapus" />
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4"><x-empty-state message="Belum ada jurusan." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>
<div class="mt-4">{{ $departments->links() }}</div>
@endsection
