@extends('layouts.admin')
@section('title', 'Edit Semester')
@section('admin-content')
<x-page-header title="Edit Semester" :back="route('admin.semesters.index')" backLabel="Semester" />
<form method="POST" action="{{ route('admin.semesters.update', $semester) }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf @method('PUT')
    @include('admin.semesters._form')
    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Update</x-button>
        <x-button href="{{ route('admin.semesters.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
