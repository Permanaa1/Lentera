{{--
    Skeleton loader untuk tabel — tampilkan saat data sedang dimuat lewat AJAX/fetch,
    atau sebagai placeholder di belakang x-data Alpine sebelum konten async siap.

    <x-skeleton-table :rows="5" :cols="5" />
--}}
@props(['rows' => 5, 'cols' => 5])
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-4 space-y-3">
        @for ($r = 0; $r < $rows; $r++)
            <div class="flex items-center gap-4">
                @for ($c = 0; $c < $cols; $c++)
                    <div class="skeleton h-4 flex-1" style="animation-delay: {{ $r * 0.05 }}s"></div>
                @endfor
            </div>
        @endfor
    </div>
</div>
