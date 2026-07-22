@props(['title', 'subtitle' => null, 'back' => null, 'backLabel' => 'Kembali', 'breadcrumbs' => []])
<div class="mb-6">
    @if (! empty($breadcrumbs))
        <nav class="flex items-center flex-wrap gap-1.5 text-xs text-gray-400 mb-2" aria-label="Breadcrumb">
            @foreach ($breadcrumbs as $item)
                @if (! $loop->last)
                    <a href="{{ $item['url'] }}" class="hover:text-primary transition">{{ $item['label'] }}</a>
                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                @else
                    <span class="text-gray-600 font-medium">{{ $item['label'] }}</span>
                @endif
            @endforeach
        </nav>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            @if ($back)
                <x-back-link :href="$back" class="mb-1.5">{{ $backLabel }}</x-back-link>
            @endif
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-5 rounded-full bg-secondary shrink-0"></span>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight">{{ $title }}</h1>
            </div>
            @if ($subtitle)
                <p class="text-sm text-gray-500 mt-1 ml-3.5">{{ $subtitle }}</p>
            @endif
        </div>
        @if (isset($actions))
            <div class="flex gap-2 shrink-0">{{ $actions }}</div>
        @endif
    </div>
</div>
