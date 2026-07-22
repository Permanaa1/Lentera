<x-input name="code" label="Kode Ruang" :value="$room->code ?? ''" placeholder="contoh: BTKR" required />
<x-input name="name" label="Nama Ruang" :value="$room->name ?? ''" placeholder="contoh: Bengkel Teknik Kendaraan Ringan" required />
<x-input type="number" name="capacity" label="Kapasitas (opsional)" :value="$room->capacity ?? ''" min="1" />
