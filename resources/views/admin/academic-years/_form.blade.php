<div>
    <label class="block text-sm font-medium mb-1">Nama Tahun Ajaran</label>
    <input type="text" name="name" value="{{ old('name', $academicYear->name ?? '') }}"
           placeholder="contoh: 2026/2027" required
           class="w-full border rounded px-3 py-2 text-sm">
    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Tanggal Mulai</label>
        <input type="date" name="start_date" value="{{ old('start_date', isset($academicYear) ? $academicYear->start_date->format('Y-m-d') : '') }}"
               required class="w-full border rounded px-3 py-2 text-sm">
        @error('start_date') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Tanggal Selesai</label>
        <input type="date" name="end_date" value="{{ old('end_date', isset($academicYear) ? $academicYear->end_date->format('Y-m-d') : '') }}"
               required class="w-full border rounded px-3 py-2 text-sm">
        @error('end_date') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>
