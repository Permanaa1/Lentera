@extends('layouts.admin')

@section('title', 'Tahun Ajaran')

@section('admin-content')
<x-page-header title="Tahun Ajaran" subtitle="Kelola periode tahun ajaran & tentukan yang aktif saat ini.">
    <x-slot:actions>
        <x-button href="{{ route('admin.academic-years.create') }}" variant="primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah
        </x-button>
    </x-slot:actions>
</x-page-header>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[560px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Periode</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-56">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($academicYears as $year)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Nama" class="px-4 py-3 font-medium text-gray-800">{{ $year->name }}</td>
                    <td data-label="Periode" class="px-4 py-3 text-gray-600">
                        {{ $year->start_date->format('d M Y') }} — {{ $year->end_date->format('d M Y') }}
                    </td>
                    <td data-label="Status" class="px-4 py-3">
                        @if ($year->is_active)
                            <x-badge color="success">Aktif</x-badge>
                        @else
                            <x-badge color="gray">Nonaktif</x-badge>
                        @endif
                    </td>
                    <td data-label="Aksi" class="px-4 py-3">
                        <div class="flex items-center gap-3 justify-end sm:justify-start flex-wrap">
                            @unless ($year->is_active)
                                <form method="POST" action="{{ route('admin.academic-years.activate', $year) }}">
                                    @csrf
                                    <button class="text-success hover:underline text-sm font-medium">Aktifkan</button>
                                </form>
                            @endunless
                            <a href="{{ route('admin.academic-years.edit', $year) }}" class="text-primary hover:underline text-sm font-medium">Edit</a>
                            <form method="POST" action="{{ route('admin.academic-years.destroy', $year) }}"
                                  onsubmit="return confirm('Yakin hapus tahun ajaran ini?')">
                                @csrf @method('DELETE')
                                <button class="text-danger hover:underline text-sm font-medium">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4"><x-empty-state message="Belum ada tahun ajaran. Klik &quot;Tambah&quot; untuk membuat yang pertama." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>

<div class="mt-4">{{ $academicYears->links() }}</div>
@endsection
