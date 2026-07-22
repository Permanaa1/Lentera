@extends('layouts.admin')
@section('title', 'Kenaikan Kelas')
@section('admin-content')
<x-page-header title="Proses Kenaikan Kelas" subtitle="Pilih kelas untuk memproses keputusan naik/tidak naik/lulus/keluar."
    :breadcrumbs="[['label' => 'Dashboard', 'url' => route('admin.dashboard')], ['label' => 'Kenaikan Kelas']]" />

<form method="GET" class="mb-4">
    <select name="academic_year_id" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2.5 min-h-[44px] text-sm bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
        @foreach ($academicYears as $year)
            <option value="{{ $year->id }}" {{ $academicYearId == $year->id ? 'selected' : '' }}>
                {{ $year->name }} {{ $year->is_active ? '(Aktif)' : '' }}
            </option>
        @endforeach
    </select>
</form>

<div class="bg-info-subtle border-l-4 border-info text-info rounded-r-lg px-4 py-3 text-sm mb-4">
    Pilih tahun ajaran yang mau <strong>ditutup</strong> (biasanya tahun ajaran yang akan berakhir), lalu proses tiap kelas satu per satu.
    Pastikan kelas untuk tahun ajaran berikutnya sudah dibuat lebih dulu di menu Kelas.
</div>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[560px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Kelas</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Tingkat</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Jurusan</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Murid Aktif</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-32 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($classes as $class)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Kelas" class="px-4 py-3 font-medium text-gray-800">{{ $class->name }}</td>
                    <td data-label="Tingkat" class="px-4 py-3 text-gray-600">{{ $class->tingkatRomawi() ?? '-' }}</td>
                    <td data-label="Jurusan" class="px-4 py-3 text-gray-600">{{ $class->department->name ?? '-' }}</td>
                    <td data-label="Murid Aktif" class="px-4 py-3"><x-badge color="primary">{{ $class->students_count }}</x-badge></td>
                    <td data-label="Aksi" class="px-4 py-3 text-right">
                        <x-button href="{{ route('admin.promotions.show', $class) }}" variant="outline">Proses</x-button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5"><x-empty-state message="Tidak ada kelas di tahun ajaran ini." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>
@endsection
