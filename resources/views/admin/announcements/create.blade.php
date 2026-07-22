@extends('layouts.admin')
@section('title', 'Buat Pengumuman')
@section('admin-content')
<x-page-header title="Buat Pengumuman" :back="route('admin.announcements.index')" backLabel="Pengumuman" />

<form method="POST" action="{{ route('admin.announcements.store') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-lg">
    @csrf
    <x-input name="title" label="Judul" required />
    <x-textarea name="content" label="Isi Pengumuman" :rows="5" required />
    <x-select name="target_role" label="Ditujukan untuk" required>
        <option value="all">Semua Pengguna</option>
        <option value="admin">Admin</option>
        <option value="teacher">Guru</option>
        <option value="student">Murid</option>
        <option value="parent">Wali Murid</option>
    </x-select>
    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Publikasikan</x-button>
        <x-button href="{{ route('admin.announcements.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
