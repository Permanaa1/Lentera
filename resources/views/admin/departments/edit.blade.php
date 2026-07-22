@extends('layouts.admin')
@section('title', 'Edit Jurusan')
@section('admin-content')
<x-page-header title="Edit Jurusan" :back="route('admin.departments.index')" backLabel="Jurusan" />
<form method="POST" action="{{ route('admin.departments.update', $department) }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf @method('PUT')
    @include('admin.departments._form')
    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Update</x-button>
        <x-button href="{{ route('admin.departments.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
