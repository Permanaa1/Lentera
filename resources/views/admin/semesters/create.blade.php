@extends('layouts.admin')
@section('title', 'Tambah Semester')
@section('admin-content')
<x-page-header title="Tambah Semester" :back="route('admin.semesters.index')" backLabel="Semester" />
<form method="POST" action="{{ route('admin.semesters.store') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf
    @include('admin.semesters._form')
    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Simpan</x-button>
        <x-button href="{{ route('admin.semesters.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
