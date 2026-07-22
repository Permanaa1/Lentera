{{--
    Tombol aksi berbasis ikon untuk kolom Aksi di tabel (hemat tempat, sesuai
    panduan UI/UX yang kamu kirim). Ukuran w-11 h-11 = 44x44px (touch-friendly).
    Pakai atribut title="..." untuk tooltip native browser saat disorot.

    Contoh pakai (link, untuk Lihat/Edit):
        <x-icon-button variant="edit" label="Edit" :href="route('admin.x.edit', $x)">
            <svg ...>...</svg>
        </x-icon-button>

    Contoh pakai (submit form, untuk Hapus):
        <form method="POST" action="...">
            @csrf @method('DELETE')
            <x-icon-button variant="delete" label="Hapus" />
        </form>
--}}
@props(['variant' => 'view', 'label' => '', 'href' => null])
@php
    $variants = [
        'view' => 'text-info hover:bg-info-subtle',
        'edit' => 'text-primary hover:bg-primary-subtle',
        'delete' => 'text-danger hover:bg-danger-subtle',
        'success' => 'text-success hover:bg-success-subtle',
    ];
    $classes = 'inline-flex items-center justify-center w-11 h-11 rounded-lg transition '
             . ($variants[$variant] ?? $variants['view']);

    $icons = [
        'view' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>',
        'edit' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>',
        'delete' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>',
        'success' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>',
    ];
    $icon = $icons[$variant] ?? $icons['view'];
@endphp
@if ($href)
    <a href="{{ $href }}" title="{{ $label }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot->isEmpty() ? new \Illuminate\Support\HtmlString($icon) : $slot }}
    </a>
@else
    <button type="submit" title="{{ $label }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot->isEmpty() ? new \Illuminate\Support\HtmlString($icon) : $slot }}
    </button>
@endif
