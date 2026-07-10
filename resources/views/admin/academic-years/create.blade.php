@extends('layouts.admin')

@section('title', 'Tambah Tahun Ajaran')

@section('admin-content')
<h1 class="text-xl font-semibold mb-6">Tambah Tahun Ajaran</h1>

<form method="POST" action="{{ route('admin.academic-years.store') }}" class="bg-white p-6 rounded-lg shadow space-y-4 max-w-md">
    @csrf
    @include('admin.academic-years._form')

    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">Simpan</button>
        <a href="{{ route('admin.academic-years.index') }}" class="px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-100">Batal</a>
    </div>
</form>
@endsection
