@extends('layouts.admin')

@section('title', 'Buat Pengumuman')

@section('admin-content')
<h1 class="text-xl font-semibold mb-6">Buat Pengumuman</h1>

<form method="POST" action="{{ route('admin.announcements.store') }}" class="bg-white p-6 rounded-lg shadow space-y-4 max-w-lg">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Judul</label>
        <input type="text" name="title" value="{{ old('title') }}" required
               class="w-full border rounded px-3 py-2 text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Isi Pengumuman</label>
        <textarea name="content" rows="5" required class="w-full border rounded px-3 py-2 text-sm">{{ old('content') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Ditujukan untuk</label>
        <select name="target_role" required class="w-full border rounded px-3 py-2 text-sm">
            <option value="all">Semua Pengguna</option>
            <option value="admin">Admin</option>
            <option value="teacher">Guru</option>
            <option value="student">Murid</option>
            <option value="parent">Wali Murid</option>
        </select>
    </div>

    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">Publikasikan</button>
        <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-100">Batal</a>
    </div>
</form>
@endsection
