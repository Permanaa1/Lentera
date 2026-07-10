<div>
    <label class="block text-sm font-medium mb-1">Tahun Ajaran</label>
    <select name="academic_year_id" required class="w-full border rounded px-3 py-2 text-sm">
        <option value="">— Pilih —</option>
        @foreach ($academicYears as $year)
            <option value="{{ $year->id }}"
                {{ (old('academic_year_id', $semester->academic_year_id ?? '')) == $year->id ? 'selected' : '' }}>
                {{ $year->name }}
            </option>
        @endforeach
    </select>
    @error('academic_year_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Nama Semester</label>
    <select name="name" required class="w-full border rounded px-3 py-2 text-sm">
        <option value="">— Pilih —</option>
        @foreach (['Ganjil', 'Genap'] as $opt)
            <option value="{{ $opt }}" {{ old('name', $semester->name ?? '') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
        @endforeach
    </select>
    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
        <input type="date" name="start_date" value="{{ old('start_date', isset($semester) ? $semester->start_date->format('Y-m-d') : '') }}"
               required class="w-full border rounded px-3 py-2 text-sm">
        @error('start_date') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Tanggal Selesai</label>
        <input type="date" name="end_date" value="{{ old('end_date', isset($semester) ? $semester->end_date->format('Y-m-d') : '') }}"
               required class="w-full border rounded px-3 py-2 text-sm">
        @error('end_date') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>
