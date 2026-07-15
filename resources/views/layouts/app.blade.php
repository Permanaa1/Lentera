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
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            DEFAULT: '#1f287d',
                            dark: '#161c5c',
                            light: '#4c56a3',
                            subtle: '#d2d4e5',
                        },
                        secondary: {
                            DEFAULT: '#e7b10a',
                            dark: '#b98b06',
                            subtle: '#faefce',
                        },
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

        /*
         * Tabel Responsif: tambahkan class="responsive-table" pada <table> dan
         * data-label="..." pada tiap <td> (isi = nama kolom di header-nya).
         * Di layar < 640px, tabel otomatis berubah jadi kartu bertumpuk
         * (bukan discroll ke samping) -- jauh lebih nyaman dibaca di HP.
         */
        @media (max-width: 639px) {
            table.responsive-table thead { display: none; }
            table.responsive-table, table.responsive-table tbody,
            table.responsive-table tr, table.responsive-table td {
                display: block; width: 100%;
            }
            table.responsive-table tr {
                margin-bottom: 0.75rem;
                border: 1px solid #e5e7eb;
                border-radius: 0.75rem;
                padding: 0.5rem 0.75rem;
            }
            table.responsive-table tr:last-child { margin-bottom: 0; }
            table.responsive-table td {
                display: block;
                padding: 0.5rem 0;
                border: none !important;
                border-bottom: 1px solid #f3f4f6 !important;
            }
            table.responsive-table td:last-child { border-bottom: none !important; }
            table.responsive-table td[data-label] {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 0.75rem;
                text-align: right;
            }
            table.responsive-table td[data-label]::before {
                content: attr(data-label);
                font-weight: 600;
                color: #6b7280;
                font-size: 0.75rem;
                text-align: left;
                margin-right: auto;
                white-space: nowrap;
            }
        }
    </style>

    @stack('head')
</head>
<body class="bg-surface text-gray-800 antialiased min-h-screen">

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
    @if (session('status'))
        <x-alert type="success" class="mb-6">{{ session('status') }}</x-alert>
    @endif

    @yield('content')
</main>

@stack('scripts')
</body>
</html>
