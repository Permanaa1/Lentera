{{--
    Bottom Navigation — hanya tampil di HP (md:hidden), untuk role tanpa sidebar
    (murid, guru, wali murid). Isi menu disesuaikan per role. Admin memakai sidebar
    di layouts/admin.blade.php jadi tidak perlu bottom-nav.
--}}
@php
    $role = auth()->user()->role ?? null;

    $items = match ($role) {
        'student' => [
            ['route' => 'student.dashboard', 'label' => 'Beranda', 'icon' => 'home'],
            ['route' => 'student.grades.index', 'label' => 'Nilai', 'icon' => 'chart'],
            ['route' => 'student.attendance.index', 'label' => 'Absensi', 'icon' => 'check'],
            ['route' => 'student.invoices.index', 'label' => 'Tagihan', 'icon' => 'bill'],
        ],
        'teacher' => [
            ['route' => 'teacher.dashboard', 'label' => 'Beranda', 'icon' => 'home'],
            ['route' => 'teacher.courses.index', 'label' => 'Course', 'icon' => 'book'],
            ['route' => 'teacher.attendance.index', 'label' => 'Absensi', 'icon' => 'check'],
            ['route' => 'teacher.report-card.index', 'label' => 'Rapor', 'icon' => 'chart'],
        ],
        'parent' => [
            ['route' => 'parent.dashboard', 'label' => 'Beranda', 'icon' => 'home'],
            ['route' => 'notifications.index', 'label' => 'Notifikasi', 'icon' => 'bell'],
        ],
        default => [],
    };

    $icons = [
        'home' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"/>',
        'chart' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6m6 13V10M3 19h18M15 19V4"/>',
        'check' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'bill' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2 2 4-4m6-3v10a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h6l4 4z"/>',
        'book' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>',
        'bell' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>',
    ];
@endphp

@if (count($items))
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-30 bg-white border-t border-gray-100 shadow-[0_-2px_8px_rgba(0,0,0,0.04)] pb-[env(safe-area-inset-bottom)]">
        <div class="grid" style="grid-template-columns: repeat({{ count($items) }}, minmax(0, 1fr));">
            @foreach ($items as $item)
                <a href="{{ route($item['route']) }}"
                   @class([
                        'flex flex-col items-center justify-center gap-0.5 min-h-[56px] text-[11px] font-medium transition',
                        'text-primary' => request()->routeIs($item['route'] . '*'),
                        'text-gray-400' => ! request()->routeIs($item['route'] . '*'),
                   ])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icons[$item['icon']] !!}</svg>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </nav>
    {{-- Spacer supaya konten terakhir tidak ketutup bottom-nav --}}
    <div class="md:hidden h-16"></div>
@endif
