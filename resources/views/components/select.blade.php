@props(['label' => null, 'name', 'hint' => null])
@php
    $hasError = $errors->has($name);
    $base = 'w-full border rounded-lg px-3 py-2.5 text-sm bg-white transition focus:outline-none focus:ring-2';
    $state = $hasError
        ? 'border-danger focus:ring-danger/20 focus:border-danger'
        : 'border-gray-300 focus:ring-primary/20 focus:border-primary';
@endphp
<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    @endif
    <select name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => "$base $state"]) }}>
        {{ $slot }}
    </select>
    @if ($hint && ! $hasError)
        <p class="text-xs text-gray-400 mt-1">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="text-xs text-danger mt-1">{{ $message }}</p>
    @enderror
</div>
