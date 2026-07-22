{{--
    Breadcrumb
    ----------
    <x-breadcrumb :items="[
        ['label' => 'Beranda', 'href' => route('admin.dashboard')],
        ['label' => 'Data Murid', 'href' => route('admin.students.index')],
        ['label' => 'Detail Murid'], // item terakhir tanpa href = halaman aktif
    ]" />
--}}
@props(['items' => []])
<nav aria-label="Breadcrumb" class="mb-2">
    <ol class="flex items-center flex-wrap gap-1 text-xs text-gray-400">
        @foreach ($items as $index => $item)
            <li class="flex items-center gap-1">
                @if (! $loop->first)
                    <svg class="w-3 h-3 text-gray-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                @endif
                @if (! empty($item['href']) && ! $loop->last)
                    <a href="{{ $item['href'] }}" class="hover:text-primary transition">{{ $item['label'] }}</a>
                @else
                    <span class="text-gray-600 font-medium">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
