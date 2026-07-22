@extends('layouts.admin')
@section('title', 'Tambah Jadwal')
@section('admin-content')
<x-page-header title="Tambah Jadwal" :back="route('admin.schedules.index')" backLabel="Jadwal" />
<form method="POST" action="{{ route('admin.schedules.store') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf
    @include('admin.schedules._form')
    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Simpan</x-button>
        <x-button href="{{ route('admin.schedules.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
