@extends('layouts.admin')
@section('title', 'Hubungkan Wali Murid')
@section('admin-content')
<x-page-header title="Hubungkan Wali Murid ke Anak" :back="route('admin.parent-links.index')" backLabel="Wali Murid & Anak" />

<form method="POST" action="{{ route('admin.parent-links.store') }}" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 space-y-4 max-w-md">
    @csrf

    <x-select name="parent_id" label="Wali Murid" required>
        <option value="">— Pilih —</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                {{ $parent->user->name ?? '-' }} ({{ $parent->user->email ?? '-' }})
            </option>
        @endforeach
    </x-select>

    <x-select name="student_id" label="Murid" required>
        <option value="">— Pilih —</option>
        @foreach ($students as $student)
            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                {{ $student->nis }} — {{ $student->user->name ?? '-' }}
            </option>
        @endforeach
    </x-select>

    <p class="text-xs text-gray-400">Satu wali murid boleh dihubungkan ke lebih dari satu anak (submit form ini berulang).</p>

    <div class="flex gap-2 pt-2">
        <x-button type="submit" variant="primary">Hubungkan</x-button>
        <x-button href="{{ route('admin.parent-links.index') }}" variant="outline">Batal</x-button>
    </div>
</form>
@endsection
