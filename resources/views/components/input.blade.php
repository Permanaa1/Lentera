@props(['label' => null, 'name', 'type' => 'text', 'value' => null, 'hint' => null])
@php
    $hasError = $errors->has($name);
    $base = 'w-full border rounded-lg px-3 py-2.5 text-sm min-h-[44px] transition focus:outline-none focus:ring-2';
    $state = $hasError
        ? 'border-danger focus:ring-danger/20 focus:border-danger'
        : 'border-gray-300 focus:ring-primary/20 focus:border-primary';
@endphp
<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    @endif
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => "$base $state"]) }}
    >
    @if ($hint && ! $hasError)
        <p class="text-xs text-gray-400 mt-1">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="text-xs text-danger mt-1 flex items-center gap-1">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>
