<x-select name="academic_year_id" label="Tahun Ajaran" required>
    <option value="">— Pilih —</option>
    @foreach ($academicYears as $year)
        <option value="{{ $year->id }}" {{ (old('academic_year_id', $semester->academic_year_id ?? '')) == $year->id ? 'selected' : '' }}>
            {{ $year->name }}
        </option>
    @endforeach
</x-select>

<x-select name="name" label="Nama Semester" required>
    <option value="">— Pilih —</option>
    @foreach (['Ganjil', 'Genap'] as $opt)
        <option value="{{ $opt }}" {{ old('name', $semester->name ?? '') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
    @endforeach
</x-select>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <x-input type="date" name="start_date" label="Tanggal Mulai" :value="isset($semester) ? $semester->start_date->format('Y-m-d') : ''" required />
    <x-input type="date" name="end_date" label="Tanggal Selesai" :value="isset($semester) ? $semester->end_date->format('Y-m-d') : ''" required />
</div>
