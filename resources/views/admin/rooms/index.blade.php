@extends('layouts.admin')
@section('title', 'Ruang Kelas')
@section('admin-content')
<x-page-header title="Ruang Kelas" subtitle="Ruang teori, bengkel, dan lab yang tersedia."
    :breadcrumbs="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Ruang Kelas']]">
    <x-slot:actions>
        <x-button href="{{ route('admin.rooms.create') }}" variant="primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah
        </x-button>
    </x-slot:actions>
</x-page-header>

<form method="GET" class="flex flex-wrap items-center gap-2 mb-4">
    <x-search-input placeholder="Cari kode/nama ruang..." />
    <x-button type="submit" variant="outline">Cari</x-button>
</form>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[520px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Kode</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Kapasitas</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Dipakai</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-28 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($rooms as $room)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Kode" class="px-4 py-3 font-mono text-gray-600">{{ $room->code }}</td>
                    <td data-label="Nama" class="px-4 py-3 font-medium text-gray-800">{{ $room->name }}</td>
                    <td data-label="Kapasitas" class="px-4 py-3 text-gray-600">{{ $room->capacity ?? '-' }}</td>
                    <td data-label="Dipakai" class="px-4 py-3"><x-badge color="primary">{{ $room->schedules_count }} jadwal</x-badge></td>
                    <td data-label="Aksi" class="px-4 py-3">
                        <div class="flex items-center gap-1 justify-end">
                            <x-icon-button variant="edit" label="Edit" :href="route('admin.rooms.edit', $room)" />
                            <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}"
                                  onsubmit="return confirm('Yakin hapus ruang ini?')">
                                @csrf @method('DELETE')
                                <x-icon-button variant="delete" label="Hapus" />
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5"><x-empty-state message="Belum ada ruang kelas." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>
<div class="mt-4">{{ $rooms->links() }}</div>
@endsection
