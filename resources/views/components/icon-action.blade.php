{{--
    Tombol aksi berbasis ikon untuk kolom "Aksi" di tabel — hemat tempat, tooltip saat hover,
    area klik tetap 44x44px agar nyaman disentuh di HP.

    <x-icon-action href="{{ route('admin.classes.edit', $class) }}" label="Edit" icon="edit" />
    <x-icon-action label="Hapus" icon="delete" variant="danger"
                    form-action="{{ route('admin.classes.destroy', $class) }}"
                    confirm="Yakin hapus kelas ini?" />
--}}
@props([
    'href' => null,
    'label',
    'icon' => 'view', // view | edit | delete
    'variant' => 'default', // default | danger
    'formAction' => null,
    'confirm' => null,
])
@php
    $icons = [
        'view' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>',
        'edit' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>',
        'delete' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>',
    ];
    $colors = $variant === 'danger'
        ? 'text-gray-400 hover:text-danger hover:bg-danger-subtle'
        : 'text-gray-400 hover:text-primary hover:bg-primary-subtle';
    $classes = "group relative inline-flex items-center justify-center w-11 h-11 rounded-lg transition $colors";
@endphp

@if ($formAction)
    <form method="POST" action="{{ $formAction }}" class="inline"
          @if ($confirm) onsubmit="return confirm('{{ $confirm }}')" @endif>
        @csrf
        @method('DELETE')
        <button type="submit" class="{{ $classes }}">
            <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icons[$icon] ?? $icons['view'] !!}</svg>
            <span class="pointer-events-none absolute bottom-full mb-1 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-800 px-2 py-1 text-[11px] text-white opacity-0 group-hover:opacity-100 transition">
                {{ $label }}
            </span>
        </button>
    </form>
@else
    <a href="{{ $href }}" class="{{ $classes }}">
        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icons[$icon] ?? $icons['view'] !!}</svg>
        <span class="pointer-events-none absolute bottom-full mb-1 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-800 px-2 py-1 text-[11px] text-white opacity-0 group-hover:opacity-100 transition">
            {{ $label }}
        </span>
    </a>
@endif
