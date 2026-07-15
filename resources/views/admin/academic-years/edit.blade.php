@extends('layouts.admin')

@section('title', 'Edit Tahun Ajaran')

@section('admin-content')
<x-page-header title="Edit Tahun Ajaran" :back="route('admin.academic-years.index')" backLabel="Tahun Ajaran" />

<form method="POST" action="{{ route('admin.academic-years.update', $academicYear) }}"
      class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf
    @method('PUT')
    @include('admin.academic-years._form')

    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Update</x-button>
        <x-button href="{{ route('admin.academic-years.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
