@extends('layouts.app')
@section('title', 'Kirim Pengumuman')
@section('content')
<x-page-header title="Kirim Pengumuman" :subtitle="$course->title" :back="route('teacher.courses.index')" backLabel="Course Saya" />

<form method="POST" action="{{ route('teacher.courses.announcements.store', $course) }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-lg">
    @csrf
    <x-input name="title" label="Judul" required />
    <x-textarea name="content" label="Isi Pengumuman" :rows="5" required />
    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Kirim</x-button>
        <x-button href="{{ route('teacher.courses.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
