@extends('layouts.admin')

@section('title', 'Tambah Tahun Ajaran')

@section('admin-content')
<x-page-header title="Tambah Tahun Ajaran" :back="route('admin.academic-years.index')" backLabel="Tahun Ajaran" />

<form method="POST" action="{{ route('admin.academic-years.store') }}"
      class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf
    @include('admin.academic-years._form')

    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Simpan</x-button>
        <x-button href="{{ route('admin.academic-years.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
