@extends('layouts.app')

@section('title', 'Kirim Pengumuman')

@section('content')
<h1 class="text-xl font-semibold mb-2">Kirim Pengumuman — {{ $course->title }}</h1>
<p class="text-sm text-gray-500 mb-6">Akan tampil untuk semua murid course ini.</p>

<form method="POST" action="{{ route('teacher.courses.announcements.store', $course) }}" class="bg-white p-6 rounded-lg shadow space-y-4 max-w-lg">
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

    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">Kirim</button>
        <a href="{{ route('teacher.courses.index') }}" class="px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-100">Batal</a>
    </div>
</form>
@endsection
