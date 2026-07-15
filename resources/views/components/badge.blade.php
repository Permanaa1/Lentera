@props(['color' => 'gray'])
@php
    $map = [
        'gray' => 'bg-gray-100 text-gray-700',
        'primary' => 'bg-primary-subtle text-primary',
        'secondary' => 'bg-secondary-subtle text-secondary-dark',
        'success' => 'bg-success-subtle text-success',
        'danger' => 'bg-danger-subtle text-danger',
        'warning' => 'bg-warning-subtle text-yellow-800',
        'info' => 'bg-info-subtle text-info',
    ];
    $classes = $map[$color] ?? $map['gray'];
@endphp
<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium whitespace-nowrap $classes"]) }}>
    {{ $slot }}
</span>
