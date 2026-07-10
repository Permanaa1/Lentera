@extends('layouts.admin')

@section('title', 'Tambah Jurusan')

@section('admin-content')
<h1 class="text-xl font-semibold mb-6">Tambah Jurusan</h1>

<form method="POST" action="{{ route('admin.departments.store') }}" class="bg-white p-6 rounded-lg shadow space-y-4 max-w-md">
    @csrf
    @include('admin.departments._form')

    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">Simpan</button>
        <a href="{{ route('admin.departments.index') }}" class="px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-100">Batal</a>
    </div>
</form>
@endsection
