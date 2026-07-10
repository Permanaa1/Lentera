<div>
    <label class="block text-sm font-medium mb-1">Kode Mata Pelajaran</label>
    <input type="text" name="code" value="{{ old('code', $subject->code ?? '') }}"
           placeholder="contoh: MTK01" required maxlength="20"
           class="w-full border rounded px-3 py-2 text-sm">
    @error('code') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Nama Mata Pelajaran</label>
    <input type="text" name="name" value="{{ old('name', $subject->name ?? '') }}"
           placeholder="contoh: Matematika Wajib" required
           class="w-full border rounded px-3 py-2 text-sm">
    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">SKS / Bobot Kredit</label>
    <input type="number" name="credit" value="{{ old('credit', $subject->credit ?? 2) }}"
           min="1" max="10" required
           class="w-full border rounded px-3 py-2 text-sm">
    @error('credit') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Deskripsi (opsional)</label>
    <textarea name="description" rows="3"
              class="w-full border rounded px-3 py-2 text-sm">{{ old('description', $subject->description ?? '') }}</textarea>
    @error('description') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>
