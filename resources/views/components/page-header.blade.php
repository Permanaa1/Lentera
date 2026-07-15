@props(['title', 'subtitle' => null, 'back' => null, 'backLabel' => 'Kembali'])
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
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
