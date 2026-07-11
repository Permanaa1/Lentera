@extends('layouts.admin')

@section('title', 'Hubungkan Wali Murid')

@section('admin-content')
<h1 class="text-xl font-semibold mb-6">Hubungkan Wali Murid ke Anak</h1>

<form method="POST" action="{{ route('admin.parent-links.store') }}" class="bg-white p-6 rounded-lg shadow space-y-4 max-w-md">
    @csrf

    <div>
        <label class="block text-sm font-medium mb-1">Wali Murid</label>
        <select name="parent_id" required class="w-full border rounded px-3 py-2 text-sm">
            <option value="">— Pilih —</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                    {{ $parent->user->name ?? '-' }} ({{ $parent->user->email ?? '-' }})
                </option>
            @endforeach
        </select>
        @error('parent_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Murid</label>
        <select name="student_id" required class="w-full border rounded px-3 py-2 text-sm">
            <option value="">— Pilih —</option>
            @foreach ($students as $student)
                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                    {{ $student->nis }} — {{ $student->user->name ?? '-' }}
                </option>
            @endforeach
        </select>
        @error('student_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <p class="text-xs text-gray-400">Satu wali murid boleh dihubungkan ke lebih dari satu anak (submit form ini berulang).</p>

    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">Hubungkan</button>
        <a href="{{ route('admin.parent-links.index') }}" class="px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-100">Batal</a>
    </div>
</form>
@endsection
