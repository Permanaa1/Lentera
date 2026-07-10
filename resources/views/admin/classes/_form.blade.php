<div>
    <label class="block text-sm font-medium mb-1">Nama Kelas</label>
    <input type="text" name="name" value="{{ old('name', $class->name ?? '') }}"
           placeholder="contoh: X IPA 1" required
           class="w-full border rounded px-3 py-2 text-sm">
    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Jurusan</label>
    <select name="department_id" required class="w-full border rounded px-3 py-2 text-sm">
        <option value="">— Pilih —</option>
        @foreach ($departments as $dept)
            <option value="{{ $dept->id }}"
                {{ (old('department_id', $class->department_id ?? '')) == $dept->id ? 'selected' : '' }}>
                {{ $dept->name }}
            </option>
        @endforeach
    </select>
    @error('department_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Tahun Ajaran</label>
    <select name="academic_year_id" required class="w-full border rounded px-3 py-2 text-sm">
        <option value="">— Pilih —</option>
        @foreach ($academicYears as $year)
            <option value="{{ $year->id }}"
                {{ (old('academic_year_id', $class->academic_year_id ?? '')) == $year->id ? 'selected' : '' }}>
                {{ $year->name }}
            </option>
        @endforeach
    </select>
    @error('academic_year_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Wali Kelas (opsional)</label>
    <select name="homeroom_teacher_id" class="w-full border rounded px-3 py-2 text-sm">
        <option value="">— Tidak ada —</option>
        @foreach ($teachers as $teacher)
            <option value="{{ $teacher->id }}"
                {{ (old('homeroom_teacher_id', $class->homeroom_teacher_id ?? '')) == $teacher->id ? 'selected' : '' }}>
                {{ $teacher->user->name ?? '-' }} ({{ $teacher->nip }})
            </option>
        @endforeach
    </select>
    @error('homeroom_teacher_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>
