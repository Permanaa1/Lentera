{{--
    Filter Bar — search + filter dropdown + reset, auto-submit via GET.
    Taruh di dalam <form method="GET"> milikmu sendiri supaya bebas menambah field filter apa saja.

    Contoh pemakaian di halaman index:

    <x-filter-bar :action="route('admin.students.index')">
        <x-filter-bar.search name="q" placeholder="Cari nama atau NIS..." />
        <x-filter-bar.select name="class_id" placeholder="Semua Kelas">
            @foreach ($classes as $class)
                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                    {{ $class->name }}
                </option>
            @endforeach
        </x-filter-bar.select>
    </x-filter-bar>
--}}
@props(['action'])
<form method="GET" action="{{ $action }}" class="flex flex-col sm:flex-row sm:items-center gap-3 mb-4">
    <div class="flex-1 flex flex-col sm:flex-row gap-3">
        {{ $slot }}
    </div>
    <div class="flex gap-2 shrink-0">
        <button type="submit"
                class="min-h-[44px] px-4 rounded-lg bg-primary text-white text-sm font-medium hover:bg-primary-dark transition inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
            </svg>
            Terapkan
        </button>
        @if (request()->anyFilled(array_diff(array_keys(request()->query()), ['page'])))
            <a href="{{ $action }}"
               class="min-h-[44px] px-3 rounded-lg border border-gray-200 text-gray-500 text-sm hover:bg-gray-50 transition inline-flex items-center">
                Reset
            </a>
        @endif
    </div>
</form>
