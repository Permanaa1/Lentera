@props(['title' => null])
<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-gray-100 p-5']) }}>
    @if ($title)
        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">{{ $title }}</h3>
    @endif
    {{ $slot }}
</div>
