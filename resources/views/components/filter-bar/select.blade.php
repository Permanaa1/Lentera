@props(['name', 'placeholder' => 'Semua'])
<select
    name="{{ $name }}"
    {{ $attributes->merge(['class' => 'min-h-[44px] border border-gray-300 rounded-lg px-3 text-sm bg-white transition focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary']) }}
>
    <option value="">{{ $placeholder }}</option>
    {{ $slot }}
</select>
