@props(['href'])
<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-1 text-sm text-gray-400 hover:text-primary transition']) }}>
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
    </svg>
    {{ $slot }}
</a>
