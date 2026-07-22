@extends('layouts.admin')
@section('title', 'Jadwal')
@section('admin-content')
<x-page-header title="Jadwal Pelajaran" subtitle="Jadwal mengajar per kelas, guru, dan ruang."
    :breadcrumbs="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Jadwal']]">
    <x-slot:actions>
        <x-button href="{{ route('admin.schedules.calendar') }}" variant="outline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Jadwal Mingguan
        </x-button>
        <x-button href="{{ route('admin.schedules.create') }}" variant="primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah
        </x-button>
    </x-slot:actions>
</x-page-header>

<form method="GET" class="mb-4">
    <select name="class_id" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2.5 min-h-[44px] text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
        <option value="">Semua Kelas</option>
        @foreach ($classes as $class)
            <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
        @endforeach
    </select>
</form>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[680px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Hari</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Jam</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Kelas</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Mata Pelajaran</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Guru</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Ruang</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-28 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($schedules as $schedule)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Hari" class="px-4 py-3 text-gray-600">{{ $schedule->day }}</td>
                    <td data-label="Jam" class="px-4 py-3 text-gray-600">{{ substr($schedule->start_time, 0, 5) }}–{{ substr($schedule->end_time, 0, 5) }}</td>
                    <td data-label="Kelas" class="px-4 py-3 font-medium text-gray-800">{{ $schedule->schoolClass->name ?? '-' }}</td>
                    <td data-label="Mata Pelajaran" class="px-4 py-3 text-gray-600">{{ $schedule->subject->name ?? '-' }}</td>
                    <td data-label="Guru" class="px-4 py-3 text-gray-600">{{ $schedule->teacher->user->name ?? '-' }}</td>
                    <td data-label="Ruang" class="px-4 py-3"><x-badge color="secondary">{{ $schedule->room->code ?? '-' }}</x-badge></td>
                    <td data-label="Aksi" class="px-4 py-3">
                        <div class="flex items-center gap-1 justify-end">
                            <x-icon-button variant="edit" label="Edit" :href="route('admin.schedules.edit', $schedule)" />
                            <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}"
                                  onsubmit="return confirm('Yakin hapus jadwal ini?')">
                                @csrf @method('DELETE')
                                <x-icon-button variant="delete" label="Hapus" />
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7"><x-empty-state message="Belum ada jadwal." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>
<div class="mt-4">{{ $schedules->links() }}</div>
@endsection
