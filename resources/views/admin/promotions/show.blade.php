@extends('layouts.admin')
@section('title', 'Proses Kenaikan Kelas')
@section('admin-content')
<x-page-header :title="'Proses Kenaikan Kelas — ' . $class->name" :back="route('admin.promotions.index')" backLabel="Kenaikan Kelas" />

@if ($students->isEmpty())
    <x-card><x-empty-state message="Tidak ada murid aktif di kelas ini." /></x-card>
@else
<form method="POST" action="{{ route('admin.promotions.store', $class) }}" id="promotion-form">
    @csrf
    <input type="hidden" name="academic_year_id" value="{{ $class->academic_year_id }}">

    {{-- Panel terapkan-ke-semua --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-4">
        <p class="text-sm font-medium text-gray-700 mb-3">Terapkan ke semua murid sekaligus</p>
        <div class="flex flex-wrap items-end gap-3">
            <div>
                <label class="block text-xs text-gray-500 mb-1">Status</label>
                <select id="bulk-status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white min-h-[44px]">
                    <option value="promoted">Naik Kelas</option>
                    <option value="retained">Tidak Naik</option>
                    <option value="graduated">Lulus</option>
                    <option value="transferred">Pindah Sekolah</option>
                    <option value="dropped_out">Keluar/DO</option>
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-500 mb-1">Kelas Tujuan (kalau Naik/Tidak Naik)</label>
                <select id="bulk-target" class="border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white min-h-[44px] min-w-[220px]">
                    <option value="">— Pilih —</option>
                    @foreach ($allClasses as $c)
                        <option value="{{ $c->id }}" {{ $suggestedNextClasses->contains('id', $c->id) ? 'data-suggested="1"' : '' }}>
                            {{ $c->name }} ({{ $c->academicYear->name ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="button" id="apply-bulk" class="bg-primary text-white px-4 py-2.5 min-h-[44px] rounded-lg text-sm font-medium hover:bg-primary-dark transition">
                Terapkan ke Semua
            </button>
        </div>
        @if ($suggestedNextClasses->isNotEmpty())
            <p class="text-xs text-gray-400 mt-2">
                Saran kelas tujuan (tingkat berikutnya, jurusan sama):
                {{ $suggestedNextClasses->pluck('name')->implode(', ') }}
            </p>
        @endif
    </div>

    <x-table-wrapper>
        <table class="responsive-table w-full text-sm min-w-[720px]">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600">NIS</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Rata Nilai</th>
                    <th class="px-4 py-3 font-semibold text-gray-600">Kehadiran</th>
                    <th class="px-4 py-3 font-semibold text-gray-600 w-40">Status</th>
                    <th class="px-4 py-3 font-semibold text-gray-600 w-48">Kelas Tujuan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($students as $i => $student)
                    <tr class="row-decision hover:bg-surface/60 transition">
                        <td data-label="NIS" class="px-4 py-3 text-gray-500">{{ $student->nis }}</td>
                        <td data-label="Nama" class="px-4 py-3 font-medium text-gray-800">{{ $student->user->name ?? '-' }}</td>
                        <td data-label="Rata Nilai" class="px-4 py-3">
                            @if ($student->avg_grade !== null)
                                <span @class(['font-semibold', 'text-success' => $student->avg_grade >= 75, 'text-danger' => $student->avg_grade < 75])>
                                    {{ $student->avg_grade }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">belum ada</span>
                            @endif
                        </td>
                        <td data-label="Kehadiran" class="px-4 py-3">
                            @if ($student->attendance_rate !== null)
                                <span @class(['font-semibold', 'text-success' => $student->attendance_rate >= 80, 'text-danger' => $student->attendance_rate < 80])>
                                    {{ $student->attendance_rate }}%
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">belum ada</span>
                            @endif
                        </td>
                        <td data-label="Status" class="px-4 py-3">
                            <input type="hidden" name="decisions[{{ $i }}][student_id]" value="{{ $student->id }}">
                            <select name="decisions[{{ $i }}][status]" class="row-status border border-gray-300 rounded-lg px-2 py-1.5 text-sm bg-white w-full">
                                <option value="promoted">Naik Kelas</option>
                                <option value="retained">Tidak Naik</option>
                                <option value="graduated">Lulus</option>
                                <option value="transferred">Pindah</option>
                                <option value="dropped_out">Keluar/DO</option>
                            </select>
                        </td>
                        <td data-label="Kelas Tujuan" class="px-4 py-3">
                            <select name="decisions[{{ $i }}][target_class_id]" class="row-target border border-gray-300 rounded-lg px-2 py-1.5 text-sm bg-white w-full">
                                <option value="">— Pilih —</option>
                                @foreach ($allClasses as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->academicYear->name ?? '-' }})</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-table-wrapper>

    <div class="mt-4 flex items-center gap-3">
        <x-button type="submit" variant="primary">Simpan Semua Keputusan</x-button>
        <p class="text-xs text-gray-400">Nilai ≥75 & kehadiran ≥80% ditandai hijau sebagai bantuan pertimbangan -- keputusan akhir tetap di tangan Anda.</p>
    </div>
</form>

<script>
    document.getElementById('apply-bulk').addEventListener('click', function () {
        const status = document.getElementById('bulk-status').value;
        const target = document.getElementById('bulk-target').value;

        document.querySelectorAll('.row-status').forEach(function (select) {
            select.value = status;
        });

        if (target) {
            document.querySelectorAll('.row-target').forEach(function (select) {
                select.value = target;
            });
        }
    });
</script>
@endif
@endsection
