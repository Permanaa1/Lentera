{{-- Bungkus <table> dengan ini. Tambahkan class="responsive-table" di <table> kalau
     mau tabel itu berubah jadi kartu bertumpuk di layar HP (lihat CSS di app.css).
     Kalau tidak, tabel akan discroll ke samping di layar kecil (fallback aman). --}}
<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden ring-1 ring-gray-900/5']) }}>
    <div class="overflow-x-auto">
        {{ $slot }}
    </div>
</div>
