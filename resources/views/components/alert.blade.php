@props(['type' => 'info'])
@php
    $map = [
        'success' => ['bg' => 'bg-success-subtle', 'border' => 'border-success', 'text' => 'text-success'],
        'danger' => ['bg' => 'bg-danger-subtle', 'border' => 'border-danger', 'text' => 'text-danger'],
        'warning' => ['bg' => 'bg-warning-subtle', 'border' => 'border-secondary', 'text' => 'text-yellow-800'],
        'info' => ['bg' => 'bg-info-subtle', 'border' => 'border-info', 'text' => 'text-info'],
    ];
    $style = $map[$type] ?? $map['info'];
@endphp
<div {{ $attributes->merge(['class' => "{$style['bg']} border-l-4 {$style['border']} {$style['text']} rounded-r-lg px-4 py-3 text-sm"]) }}>
    {{ $slot }}
</div>
