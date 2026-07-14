@extends('layouts.app')

@section('title', 'Absensi Saya')

@section('content')
<h1 class="text-xl font-semibold mb-6">Absensi Saya</h1>

<div class="bg-white p-4 rounded-lg shadow mb-6">
    <p class="text-sm font-medium mb-3">Rekap Keseluruhan</p>
    <div class="grid grid-cols-4 gap-4 text-sm">
        <div>Hadir: <span class="font-medium text-green-700">{{ $recap['present'] ?? 0 }}</span></div>
        <div>Alpa: <span class="font-medium text-red-700">{{ $recap['absent'] ?? 0 }}</span></div>
        <div>Sakit: <span class="font-medium text-yellow-700">{{ $recap['sick'] ?? 0 }}</span></div>
        <div>Izin: <span class="font-medium text-blue-700">{{ $recap['permission'] ?? 0 }}</span></div>
    </div>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <div class="px-4 py-3 border-b font-medium text-sm">Riwayat Absensi</div>
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Tanggal</th>
                <th class="px-4 py-2">Mata Pelajaran</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($history as $a)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($a->attendance_date)->translatedFormat('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $a->schedule->subject->name ?? '-' }}</td>
                    <td class="px-4 py-2">
                        @php
                            $labels = ['present' => 'Hadir', 'absent' => 'Alpa', 'sick' => 'Sakit', 'permission' => 'Izin'];
                            $colors = [
                                'present' => 'bg-green-100 text-green-800',
                                'absent' => 'bg-red-100 text-red-800',
                                'sick' => 'bg-yellow-100 text-yellow-800',
                                'permission' => 'bg-blue-100 text-blue-800',
                            ];
                        @endphp
                        <span class="px-2 py-0.5 rounded text-xs {{ $colors[$a->status] }}">{{ $labels[$a->status] }}</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3" class="px-4 py-6 text-center text-gray-400">Belum ada riwayat absensi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $history->links() }}</div>
@endsection
