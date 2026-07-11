@extends('layouts.admin')

@section('title', 'Wali Murid & Anak')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Hubungan Wali Murid & Anak</h1>
    <a href="{{ route('admin.parent-links.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">+ Hubungkan</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Wali Murid</th>
                <th class="px-4 py-2">Murid</th>
                <th class="px-4 py-2">Kelas</th>
                <th class="px-4 py-2 w-24">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($links as $link)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $link->parentUser->user->name ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $link->student->user->name ?? '-' }} ({{ $link->student->nis ?? '-' }})</td>
                    <td class="px-4 py-2">{{ $link->student->schoolClass->name ?? '-' }}</td>
                    <td class="px-4 py-2">
                        <form method="POST" action="{{ route('admin.parent-links.destroy', $link) }}" class="inline"
                              onsubmit="return confirm('Putus hubungan ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Putus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-400">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $links->links() }}</div>
@endsection
