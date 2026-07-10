@extends('layouts.app')

@section('content')
<div class="flex gap-6 items-start">
    <aside class="w-56 shrink-0">
        <nav class="bg-white rounded-lg shadow p-3 text-sm space-y-1 sticky top-6">
            @php
                $menu = [
                    ['route' => 'admin.dashboard', 'label' => 'Dashboard'],
                    ['route' => 'admin.users.index', 'label' => 'Pengguna'],
                    ['route' => 'admin.academic-years.index', 'label' => 'Tahun Ajaran'],
                    ['route' => 'admin.semesters.index', 'label' => 'Semester'],
                    ['route' => 'admin.departments.index', 'label' => 'Jurusan'],
                    ['route' => 'admin.subjects.index', 'label' => 'Mata Pelajaran'],
                    ['route' => 'admin.classes.index', 'label' => 'Kelas (Rombel)'],
                    ['route' => 'admin.schedules.index', 'label' => 'Jadwal'],
                ];
            @endphp

            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}"
                   @class([
                        'block px-3 py-2 rounded',
                        'bg-indigo-50 text-indigo-700 font-medium' => request()->routeIs($item['route'] . '*'),
                        'text-gray-600 hover:bg-gray-50' => ! request()->routeIs($item['route'] . '*'),
                   ])>
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
    </aside>

    <div class="flex-1 min-w-0">
        @yield('admin-content')
    </div>
</div>
@endsection
