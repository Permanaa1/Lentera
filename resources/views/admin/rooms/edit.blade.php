@extends('layouts.admin')
@section('title', 'Edit Ruang Kelas')
@section('admin-content')
<x-page-header title="Edit Ruang Kelas" :back="route('admin.rooms.index')" backLabel="Ruang Kelas" />
<form method="POST" action="{{ route('admin.rooms.update', $room) }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf @method('PUT')
    @include('admin.rooms._form')
    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Update</x-button>
        <x-button href="{{ route('admin.rooms.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
