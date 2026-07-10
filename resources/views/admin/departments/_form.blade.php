<div>
    <label class="block text-sm font-medium mb-1">Kode Jurusan</label>
    <input type="text" name="code" value="{{ old('code', $department->code ?? '') }}"
           placeholder="contoh: IPA" required maxlength="20"
           class="w-full border rounded px-3 py-2 text-sm">
    @error('code') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Nama Jurusan</label>
    <input type="text" name="name" value="{{ old('name', $department->name ?? '') }}"
           placeholder="contoh: Ilmu Pengetahuan Alam" required
           class="w-full border rounded px-3 py-2 text-sm">
    @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>
