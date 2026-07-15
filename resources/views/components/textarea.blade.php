@props(['label' => null, 'name', 'value' => null, 'rows' => 4])
@php
    $hasError = $errors->has($name);
    $base = 'w-full border rounded-lg px-3 py-2.5 text-sm transition focus:outline-none focus:ring-2';
    $state = $hasError
        ? 'border-danger focus:ring-danger/20 focus:border-danger'
        : 'border-gray-300 focus:ring-primary/20 focus:border-primary';
@endphp
<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    @endif
    <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}"
              {{ $attributes->merge(['class' => "$base $state"]) }}>{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="text-xs text-danger mt-1">{{ $message }}</p>
    @enderror
</div>
