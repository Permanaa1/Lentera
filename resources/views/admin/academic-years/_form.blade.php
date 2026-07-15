<x-input name="name" label="Nama Tahun Ajaran" :value="$academicYear->name ?? ''"
         placeholder="contoh: 2026/2027" required hint="Format bebas, biasanya tahun/tahun+1." />

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <x-input type="date" name="start_date" label="Tanggal Mulai"
             :value="isset($academicYear) ? $academicYear->start_date->format('Y-m-d') : ''" required />
    <x-input type="date" name="end_date" label="Tanggal Selesai"
             :value="isset($academicYear) ? $academicYear->end_date->format('Y-m-d') : ''" required />
</div>
