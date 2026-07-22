@extends('layouts.admin')
@section('title', 'Wali Murid & Anak')
@section('admin-content')
<x-page-header title="Wali Murid & Anak" subtitle="Kelola hubungan akun wali murid dengan murid (fallback manual)."
    :breadcrumbs="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Wali Murid & Anak']]">
    <x-slot:actions>
        <x-button href="{{ route('admin.parent-links.create') }}" variant="primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Hubungkan
        </x-button>
    </x-slot:actions>
</x-page-header>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[560px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Wali Murid</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Murid</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Kelas</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-20 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($links as $link)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Wali Murid" class="px-4 py-3 font-medium text-gray-800">{{ $link->parentUser->user->name ?? '-' }}</td>
                    <td data-label="Murid" class="px-4 py-3 text-gray-600">{{ $link->student->user->name ?? '-' }} ({{ $link->student->nis ?? '-' }})</td>
                    <td data-label="Kelas" class="px-4 py-3 text-gray-600">{{ $link->student->schoolClass->name ?? '-' }}</td>
                    <td data-label="Aksi" class="px-4 py-3 text-right">
                        <form method="POST" action="{{ route('admin.parent-links.destroy', $link) }}" class="inline-block"
                              onsubmit="return confirm('Putus hubungan ini?')">
                            @csrf @method('DELETE')
                            <x-icon-button variant="delete" label="Putus Hubungan" />
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4"><x-empty-state message="Belum ada hubungan wali murid & anak." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>

<div class="mt-4">{{ $links->links() }}</div>
@endsection
