<div>
    <label class="block text-sm font-medium mb-1">Kode Ruang</label>
    <input type="text" name="code" value="{{ old('code', $room->code ?? '') }}"
           placeholder="contoh: R201" required maxlength="20"
           class="w-full border rounded px-3 py-2 text-sm">
    @error('code') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Nama Ruang</label>
    <input type="text" name="name" value="{{ old('name', $room->name ?? '') }}"
           placeholder="contoh: Ruang 201 Lantai 2" required
           class="w-full border rounded px-3 py-2 text-sm">
    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Kapasitas (opsional)</label>
    <input type="number" name="capacity" value="{{ old('capacity', $room->capacity ?? '') }}"
           min="1" class="w-full border rounded px-3 py-2 text-sm">
    @error('capacity') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>
