@extends('layouts.admin')
@section('title', 'Tambah Mata Pelajaran')
@section('admin-content')
<x-page-header title="Tambah Mata Pelajaran" :back="route('admin.subjects.index')" backLabel="Mata Pelajaran" />
<form method="POST" action="{{ route('admin.subjects.store') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf
    @include('admin.subjects._form')
    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Simpan</x-button>
        <x-button href="{{ route('admin.subjects.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
