@extends('layouts.admin')

@section('title', 'Tahun Ajaran')

@section('admin-content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">Tahun Ajaran</h1>
    <a href="{{ route('admin.academic-years.create') }}"
       class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">+ Tambah</a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Periode</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2 w-56">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($academicYears as $year)
                <tr class="border-t">
                    <td class="px-4 py-2 font-medium">{{ $year->name }}</td>
                    <td class="px-4 py-2">{{ $year->start_date->format('d M Y') }} — {{ $year->end_date->format('d M Y') }}</td>
                    <td class="px-4 py-2">
                        @if ($year->is_active)
                            <span class="px-2 py-0.5 rounded text-xs bg-green-100 text-green-800">Aktif</span>
                        @else
                            <span class="px-2 py-0.5 rounded text-xs bg-gray-200 text-gray-600">Nonaktif</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 space-x-2">
                        @unless ($year->is_active)
                            <form method="POST" action="{{ route('admin.academic-years.activate', $year) }}" class="inline">
                                @csrf
                                <button class="text-green-600 hover:underline">Aktifkan</button>
                            </form>
                        @endunless
                        <a href="{{ route('admin.academic-years.edit', $year) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('admin.academic-years.destroy', $year) }}" class="inline"
                              onsubmit="return confirm('Yakin hapus tahun ajaran ini?')">
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

<div class="mt-4">{{ $academicYears->links() }}</div>
@endsection
