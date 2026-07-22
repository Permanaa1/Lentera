@extends('layouts.admin')
@section('title', 'Tambah Kelas')
@section('admin-content')
<x-page-header title="Tambah Kelas" :back="route('admin.classes.index')" backLabel="Kelas" />
<form method="POST" action="{{ route('admin.classes.store') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf
    @include('admin.classes._form')
    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Simpan</x-button>
        <x-button href="{{ route('admin.classes.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
