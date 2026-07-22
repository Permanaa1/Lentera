{{-- Kotak pencarian standar untuk halaman index -- submit via form GET yang membungkusnya. --}}
@props(['name' => 'search', 'placeholder' => 'Cari...'])
<div class="relative flex-1 min-w-[180px]">
    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>
    <input type="text" name="{{ $name }}" value="{{ request($name) }}" placeholder="{{ $placeholder }}"
           {{ $attributes->merge(['class' => 'w-full pl-9 pr-3 py-2.5 min-h-[44px] border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition']) }}>
</div>
