{{-- Bungkus <table> dengan ini. Tambahkan class="responsive-table" di <table> kalau
     mau tabel itu berubah jadi kartu bertumpuk di layar HP (lihat CSS di layouts/app.blade.php).
     Kalau tidak, tabel akan discroll ke samping di layar kecil (fallback aman). --}}
<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden']) }}>
    <div class="overflow-x-auto">
        {{ $slot }}
    </div>
</div>
