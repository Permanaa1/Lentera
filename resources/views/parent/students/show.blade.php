@extends('layouts.app')

@section('title', 'Detail Anak')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-xl font-semibold">{{ $student->user->name ?? '-' }}</h1>
    <a href="{{ route('parent.dashboard') }}" class="text-sm text-indigo-600 hover:underline">← Dashboard</a>
</div>

<div class="bg-white p-4 rounded-lg shadow mb-6 text-sm">
    <p><span class="text-gray-500">NIS:</span> {{ $student->nis }}</p>
    <p><span class="text-gray-500">Kelas:</span> {{ $student->schoolClass->name ?? 'Belum ditempatkan' }}</p>
</div>

<div class="grid md:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-3 border-b font-medium text-sm">Nilai</div>
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Mapel</th>
                    <th class="px-4 py-2">Nilai Akhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($grades as $grade)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $grade->course->subject->name ?? '-' }}</td>
                        <td class="px-4 py-2 font-medium">{{ $grade->final_score ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="px-4 py-6 text-center text-gray-400">Belum ada nilai.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-lg shadow p-4">
        <p class="font-medium text-sm mb-3">Rekap Kehadiran</p>
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div>Hadir: <span class="font-medium">{{ $attendanceRecap['present'] ?? 0 }}</span></div>
            <div>Alpa: <span class="font-medium">{{ $attendanceRecap['absent'] ?? 0 }}</span></div>
            <div>Sakit: <span class="font-medium">{{ $attendanceRecap['sick'] ?? 0 }}</span></div>
            <div>Izin: <span class="font-medium">{{ $attendanceRecap['permission'] ?? 0 }}</span></div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-3 border-b font-medium text-sm">Jadwal Pelajaran</div>
        <table class="w-full text-sm">
            <tbody>
                @forelse ($schedules as $s)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $s->day }}</td>
                        <td class="px-4 py-2">{{ substr($s->start_time, 0, 5) }}–{{ substr($s->end_time, 0, 5) }}</td>
                        <td class="px-4 py-2">{{ $s->subject->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td class="px-4 py-6 text-center text-gray-400">Belum ada jadwal.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-4 py-3 border-b font-medium text-sm">Tagihan</div>
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2">Jenis</th>
                    <th class="px-4 py-2">Jumlah</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($invoices as $invoice)
                    <tr class="border-t">
                        <td class="px-4 py-2 uppercase text-xs">{{ $invoice->invoice_type }}</td>
                        <td class="px-4 py-2">Rp{{ number_format($invoice->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <span @class([
                                'px-2 py-0.5 rounded text-xs',
                                'bg-red-100 text-red-800' => $invoice->status === 'unpaid',
                                'bg-green-100 text-green-800' => $invoice->status === 'paid',
                            ])>{{ $invoice->status }}</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada tagihan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
