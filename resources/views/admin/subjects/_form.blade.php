<x-input name="code" label="Kode Mata Pelajaran" :value="$subject->code ?? ''" placeholder="contoh: PDS" required />
<x-input name="name" label="Nama Mata Pelajaran" :value="$subject->name ?? ''" placeholder="contoh: Pemrograman Dasar" required />
<x-input type="number" name="credit" label="SKS / Bobot Kredit" :value="$subject->credit ?? 2" min="1" max="10" required />
<x-textarea name="description" label="Deskripsi (opsional)" :value="$subject->description ?? ''" />
