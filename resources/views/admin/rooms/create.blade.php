@extends('layouts.admin')
@section('title', 'Tambah Ruang Kelas')
@section('admin-content')
<x-page-header title="Tambah Ruang Kelas" :back="route('admin.rooms.index')" backLabel="Ruang Kelas" />
<form method="POST" action="{{ route('admin.rooms.store') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf
    @include('admin.rooms._form')
    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Simpan</x-button>
        <x-button href="{{ route('admin.rooms.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
