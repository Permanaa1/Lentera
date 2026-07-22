<x-input name="name" label="Nama Kelas" :value="$class->name ?? ''" placeholder="contoh: X PPLG 1" required />

<x-select name="tingkat" label="Tingkat">
    <option value="">— Tidak diatur —</option>
    @foreach ([10 => 'X', 11 => 'XI', 12 => 'XII'] as $val => $label)
        <option value="{{ $val }}" {{ old('tingkat', $class->tingkat ?? '') == $val ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
</x-select>
<p class="text-xs text-gray-400 -mt-3">Dipakai untuk saran otomatis saat proses kenaikan kelas nanti.</p>

<x-select name="department_id" label="Jurusan" required>
    <option value="">— Pilih —</option>
    @foreach ($departments as $dept)
        <option value="{{ $dept->id }}" {{ (old('department_id', $class->department_id ?? '')) == $dept->id ? 'selected' : '' }}>
            {{ $dept->name }}
        </option>
    @endforeach
</x-select>

<x-select name="academic_year_id" label="Tahun Ajaran" required>
    <option value="">— Pilih —</option>
    @foreach ($academicYears as $year)
        <option value="{{ $year->id }}" {{ (old('academic_year_id', $class->academic_year_id ?? '')) == $year->id ? 'selected' : '' }}>
            {{ $year->name }}
        </option>
    @endforeach
</x-select>

<x-select name="homeroom_teacher_id" label="Wali Kelas (opsional)">
    <option value="">— Tidak ada —</option>
    @foreach ($teachers as $teacher)
        <option value="{{ $teacher->id }}" {{ (old('homeroom_teacher_id', $class->homeroom_teacher_id ?? '')) == $teacher->id ? 'selected' : '' }}>
            {{ $teacher->user->name ?? '-' }} ({{ $teacher->nip }})
        </option>
    @endforeach
</x-select>
