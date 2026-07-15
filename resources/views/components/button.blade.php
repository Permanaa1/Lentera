@props(['variant' => 'primary', 'href' => null])
@php
    $base = 'inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition focus:outline-none focus:ring-2 focus:ring-offset-1';
    $variants = [
        'primary' => 'bg-primary text-white hover:bg-primary-dark focus:ring-primary',
        'secondary' => 'bg-secondary text-primary-dark hover:bg-secondary-dark focus:ring-secondary',
        'outline' => 'border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 focus:ring-gray-300',
        'danger' => 'bg-danger text-white hover:bg-red-700 focus:ring-danger',
    ];
    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']);
@endphp
@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
