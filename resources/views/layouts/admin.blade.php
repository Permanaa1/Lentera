@extends('layouts.app')

@section('content')
<div x-data="{ sidebarOpen: false }">
    <div class="md:hidden mb-4">
        <button @click="sidebarOpen = true"
                class="flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg shadow-sm text-sm text-gray-700 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            Menu Admin
        </button>
    </div>

    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/40 z-40 md:hidden" x-transition.opacity></div>

    <div class="md:flex md:gap-6 md:items-start">
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed top-0 left-0 h-screen w-72 bg-white z-50 p-4 overflow-y-auto
                   transition-transform duration-200 ease-in-out shadow-2xl
                   md:static md:h-auto md:w-60 md:shrink-0 md:translate-x-0 md:z-auto
                   md:p-3 md:shadow-sm md:rounded-xl md:border md:border-gray-100">

            <div class="flex items-center justify-between mb-4 md:hidden">
                <span class="font-semibold text-primary">Menu Admin</span>
                <button @click="sidebarOpen = false" class="p-1 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="text-sm space-y-4 md:sticky md:top-24">
                @php
                    $groups = [
                        'Utama' => [
                            ['route' => 'admin.dashboard', 'label' => 'Dashboard'],
                            ['route' => 'admin.users.index', 'label' => 'Pengguna'],
                            ['route' => 'admin.students.index', 'label' => 'Kelola Murid'],
                            ['route' => 'admin.promotions.index', 'label' => 'Kenaikan Kelas'],
                            ['route' => 'admin.parent-links.index', 'label' => 'Wali Murid & Anak'],
                        ],
                        'Akademik' => [
                            ['route' => 'admin.academic-years.index', 'label' => 'Tahun Ajaran'],
                            ['route' => 'admin.semesters.index', 'label' => 'Semester'],
                            ['route' => 'admin.departments.index', 'label' => 'Jurusan'],
                            ['route' => 'admin.subjects.index', 'label' => 'Mata Pelajaran'],
                            ['route' => 'admin.classes.index', 'label' => 'Kelas (Rombel)'],
                            ['route' => 'admin.rooms.index', 'label' => 'Ruang Kelas'],
                            ['route' => 'admin.schedules.index', 'label' => 'Jadwal'],
                        ],
                        'Keuangan' => [
                            ['route' => 'admin.invoices.index', 'label' => 'Tagihan'],
                            ['route' => 'admin.payments.index', 'label' => 'Pembayaran'],
                        ],
                        'Komunikasi' => [
                            ['route' => 'admin.announcements.index', 'label' => 'Pengumuman'],
                        ],
                    ];
                @endphp

                @foreach ($groups as $groupLabel => $items)
                    <div>
                        <p class="px-3 text-[11px] font-semibold text-gray-400 uppercase tracking-wider mb-1">{{ $groupLabel }}</p>
                        <div class="space-y-0.5">
                            @foreach ($items as $item)
                                <a href="{{ route($item['route']) }}"
                                   @class([
                                        'flex items-center px-3 py-2 rounded-lg transition text-sm',
                                        'bg-primary text-white font-medium shadow-sm' => request()->routeIs($item['route'] . '*'),
                                        'text-gray-600 hover:bg-surface' => ! request()->routeIs($item['route'] . '*'),
                                   ])>
                                    {{ $item['label'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>
        </aside>

        <div class="flex-1 min-w-0 mt-4 md:mt-0">
            @yield('admin-content')
        </div>
    </div>
</div>
@endsection
