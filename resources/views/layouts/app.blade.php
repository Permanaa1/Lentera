<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — E-Learning SMK</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'system-ui', 'sans-serif'] },
                    colors: {
                        primary: { DEFAULT: '#1f287d', dark: '#161c5c', light: '#4c56a3', subtle: '#d2d4e5' },
                        secondary: { DEFAULT: '#e7b10a', dark: '#b98b06', subtle: '#faefce' },
                        success: { DEFAULT: '#13847b', subtle: '#d0e6e5' },
                        danger: { DEFAULT: '#e12d2d', subtle: '#f9d5d5' },
                        warning: { DEFAULT: '#f7d456', subtle: '#fdf6dd' },
                        info: { DEFAULT: '#0279b0', subtle: '#cff4fc' },
                        surface: '#f5f8ff',
                    },
                },
            },
        };
    </script>
    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        [x-cloak] { display: none !important; }

        /* ============ Tabel Responsif & Premium UI ============ */
        table.responsive-table {
            width: 100%;
            border-collapse: separate !important;
            border-spacing: 0 !important;
        }

        /* Header (Desktop) */
        table.responsive-table thead th {
            background-color: #ffffff !important;
            color: #161c5c !important; /* primary-dark */
            font-weight: 700 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            padding: 1rem 1.25rem !important;
            border-bottom: 2px solid #d2d4e5 !important; /* primary-subtle */
        }

        /* Padding Khusus Kiri & Kanan */
        table.responsive-table th:first-child,
        table.responsive-table td:first-child {
            padding-left: 1.5rem !important;
        }
        table.responsive-table th:last-child,
        table.responsive-table td:last-child {
            padding-right: 1.5rem !important;
        }

        /* Baris Data (Desktop) */
        table.responsive-table tbody tr {
            transition: background-color 0.2s ease;
        }
        table.responsive-table tbody tr:hover {
            background-color: #f5f8ff !important; /* surface */
        }
        table.responsive-table tbody td {
            padding: 1rem 1.25rem;
            color: #374151; /* gray-700 */
        }
        
        /* Border antar baris untuk Desktop */
        table.responsive-table tbody tr + tr > td {
            border-top: 1px solid #f3f4f6; /* gray-100 */
        }

        /* Mobile: Berubah jadi Kartu Bertumpuk */
        /* Breakpoint diubah ke 1023px agar tablet/layar sempit juga menggunakan mode kartu yang rapi */
        @media (max-width: 1023px) {
            table.responsive-table thead { display: none; }
            table.responsive-table, table.responsive-table tbody,
            table.responsive-table tr, table.responsive-table td {
                display: block; width: 100%;
            }
            
            /* Hanya jadikan kartu jika memiliki data-label */
            table.responsive-table tr:has(td[data-label]) {
                margin-bottom: 1.25rem;
                background: #ffffff;
                border: 1px solid #e5e7eb; /* gray-200 */
                border-radius: 1rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                padding: 0;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                overflow: hidden;
            }
            table.responsive-table tr:has(td[data-label]):hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
            }
            table.responsive-table tr:last-child { margin-bottom: 0; }
            
            table.responsive-table td[data-label] {
                display: block;
                padding: 0.875rem 1.25rem !important;
                border: none !important;
                border-bottom: 1px solid #f3f4f6 !important; /* gray-100 */
                text-align: left;
            }
            table.responsive-table tr:has(td[data-label]) td:last-child { border-bottom: none !important; }
            
            /* Reset padding untuk first/last child di mobile */
            table.responsive-table th:first-child,
            table.responsive-table td:first-child,
            table.responsive-table th:last-child,
            table.responsive-table td:last-child {
                padding-left: 1.25rem !important;
                padding-right: 1.25rem !important;
            }
            
            table.responsive-table td[data-label]::before {
                content: attr(data-label);
                display: block;
                font-weight: 700;
                color: #9ca3af; /* gray-400 */
                font-size: 0.7rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                margin-bottom: 0.375rem;
            }
            
            /* Sembunyikan border-top desktop di mobile */
            table.responsive-table tbody tr + tr > td {
                border-top: none;
            }
        }
    </style>

    @stack('head')
</head>
<body class="bg-surface text-gray-800 antialiased min-h-screen">

{{--
    TOAST NOTIFICATION
    Menggantikan banner sukses yang selalu tampil di atas halaman -- sekarang
    muncul sebagai notifikasi kecil di pojok kanan atas, auto-hilang setelah 4 detik.
    Heuristik warna: kalau pesan mengandung kata "tidak bisa/gagal/ditolak/salah"
    ditampilkan merah (danger), selain itu hijau (success). Ini perkiraan sederhana
    karena seluruh flash message di controller memakai satu key session('status')
    yang sama baik untuk pesan sukses maupun pesan gagal/guard-clause.
--}}
<div
    x-data="{
        toasts: [],
        add(message, type) {
            const id = Date.now() + Math.random();
            this.toasts.push({ id, message, type });
            setTimeout(() => this.remove(id), 4000);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        },
    }"
    @if (session('status'))
        x-init="add(@js(session('status')), @js(
            \Illuminate\Support\Str::contains(session('status'), ['Tidak bisa', 'tidak bisa', 'gagal', 'Gagal', 'ditolak', 'salah', 'Sudah ada', 'sudah terhubung'])
                ? 'danger'
                : 'success'
        ))"
    @endif
    class="fixed top-4 right-4 z-[100] w-full max-w-xs sm:max-w-sm px-4 sm:px-0 space-y-2 pointer-events-none"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-x-4"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            :class="toast.type === 'danger' ? 'border-danger' : 'border-success'"
            class="pointer-events-auto bg-white border-l-4 rounded-lg shadow-lg px-4 py-3 text-sm flex items-start gap-2"
        >
            <svg x-show="toast.type !== 'danger'" class="w-5 h-5 text-success shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <svg x-show="toast.type === 'danger'" class="w-5 h-5 text-danger shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span x-text="toast.message" class="flex-1 text-gray-700"></span>
            <button @click="remove(toast.id)" class="text-gray-300 hover:text-gray-500 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </template>
</div>

@auth
<nav class="bg-gradient-to-r from-primary to-primary-dark border-b border-primary-light/30 shadow-sm sticky top-0 z-30">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white font-semibold shrink-0">
                <span class="w-8 h-8 rounded-lg bg-secondary text-primary-dark flex items-center justify-center font-bold text-sm">
                    E
                </span>
                <span class="hidden sm:inline">E-Learning SMK</span>
            </a>

            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('notifications.index') }}" class="relative text-white/80 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2c0 .5-.2 1-.6 1.4L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @php $unread = auth()->user()->notifications()->where('is_read', false)->count(); @endphp
                    @if ($unread > 0)
                        <span class="absolute top-0 right-0 w-4 h-4 flex items-center justify-center bg-danger text-white text-[10px] rounded-full ring-2 ring-primary">
                            {{ $unread > 9 ? '9+' : $unread }}
                        </span>
                    @endif
                </a>

                <div class="hidden sm:flex items-center gap-2 text-sm text-white/90 max-w-[160px] md:max-w-none truncate">
                    <span class="truncate">{{ auth()->user()->name }}</span>
                    <span class="px-2 py-0.5 bg-white/15 rounded-full text-[10px] uppercase tracking-wide shrink-0">
                        {{ auth()->user()->role }}
                    </span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-white/80 hover:text-white px-2 py-1.5 rounded-lg hover:bg-white/10 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
@endauth

<main class="max-w-6xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
    @yield('content')
</main>

@stack('scripts')
</body>
</html>
