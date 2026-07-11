@extends('layouts.admin')

@section('title', 'Edit Murid')

@section('admin-content')
<h1 class="text-xl font-semibold mb-6">Edit Murid — {{ $student->user->name ?? '-' }}</h1>

<form method="POST" action="{{ route('admin.students.update', $student) }}" class="bg-white p-6 rounded-lg shadow space-y-4 max-w-md">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-sm font-medium mb-1">Kelas</label>
        <select name="class_id" class="w-full border rounded px-3 py-2 text-sm">
            <option value="">— Belum ditempatkan —</option>
            @foreach ($classes as $class)
                <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Status Akademik</label>
        <select name="academic_status" required class="w-full border rounded px-3 py-2 text-sm">
            @foreach (['active' => 'Aktif', 'leave' => 'Cuti', 'graduated' => 'Lulus'] as $val => $label)
                <option value="{{ $val }}" {{ old('academic_status', $student->academic_status) == $val ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex gap-2">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded text-sm hover:bg-indigo-700">Simpan</button>
        <a href="{{ route('admin.students.index') }}" class="px-4 py-2 rounded text-sm text-gray-600 hover:bg-gray-100">Batal</a>
    </div>
</form>
@endsection
