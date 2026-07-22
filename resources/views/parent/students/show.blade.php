@extends('layouts.app')
@section('title', 'Detail Anak')
@section('content')
<x-page-header :title="$student->user->name ?? '-'" :back="route('parent.dashboard')" backLabel="Dashboard" />

<x-card class="mb-6">
    <p class="text-sm"><span class="text-gray-500">NIS:</span> <span class="font-medium">{{ $student->nis }}</span></p>
    <p class="text-sm"><span class="text-gray-500">Kelas:</span> {{ $student->schoolClass->name ?? 'Belum ditempatkan' }}</p>
</x-card>

<div class="grid md:grid-cols-2 gap-6">
    <x-table-wrapper>
        <table class="responsive-table w-full text-sm min-w-[300px]">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600" colspan="2">Nilai</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($grades as $grade)
                    <tr>
                        <td data-label="Mapel" class="px-4 py-3 text-gray-700">{{ $grade->course->subject->name ?? '-' }}</td>
                        <td data-label="Nilai" class="px-4 py-3 font-semibold text-primary">{{ $grade->final_score ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2"><x-empty-state message="Belum ada nilai." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-table-wrapper>

    <x-card title="Rekap Kehadiran">
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><span class="text-gray-500 block text-xs">Hadir</span> <span class="font-semibold text-success text-lg">{{ $attendanceRecap['present'] ?? 0 }}</span></div>
            <div><span class="text-gray-500 block text-xs">Alpa</span> <span class="font-semibold text-danger text-lg">{{ $attendanceRecap['absent'] ?? 0 }}</span></div>
            <div><span class="text-gray-500 block text-xs">Sakit</span> <span class="font-semibold text-yellow-700 text-lg">{{ $attendanceRecap['sick'] ?? 0 }}</span></div>
            <div><span class="text-gray-500 block text-xs">Izin</span> <span class="font-semibold text-info text-lg">{{ $attendanceRecap['permission'] ?? 0 }}</span></div>
        </div>
    </x-card>

    <x-table-wrapper>
        <table class="responsive-table w-full text-sm min-w-[400px]">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600" colspan="3">Jadwal Pelajaran</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($schedules as $s)
                    <tr>
                        <td data-label="Hari" class="px-4 py-3 text-gray-600">{{ $s->day }}</td>
                        <td data-label="Jam" class="px-4 py-3 text-gray-600">{{ substr($s->start_time, 0, 5) }}–{{ substr($s->end_time, 0, 5) }}</td>
                        <td data-label="Mapel" class="px-4 py-3 font-medium text-gray-800">{{ $s->subject->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3"><x-empty-state message="Belum ada jadwal." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-table-wrapper>

    <x-table-wrapper>
        <table class="responsive-table w-full text-sm min-w-[400px]">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-4 py-3 font-semibold text-gray-600" colspan="3">Tagihan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($invoices as $invoice)
                    <tr>
                        <td data-label="Jenis" class="px-4 py-3"><x-badge color="secondary">{{ strtoupper($invoice->invoice_type) }}</x-badge></td>
                        <td data-label="Jumlah" class="px-4 py-3 font-medium">Rp{{ number_format($invoice->amount, 0, ',', '.') }}</td>
                        <td data-label="Status" class="px-4 py-3">
                            <x-badge :color="$invoice->status === 'paid' ? 'success' : 'danger'">{{ $invoice->status }}</x-badge>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3"><x-empty-state message="Belum ada tagihan." /></td></tr>
                @endforelse
            </tbody>
        </table>
    </x-table-wrapper>
</div>
@endsection
