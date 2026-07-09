<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Learning') — Sistem Akademik</title>
    {{-- Sementara pakai Tailwind CDN untuk checkpoint testing Fase 1-3.
         Ganti ke build Vite (npm run build) begitu masuk Fase Frontend penuh. --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    @auth
    <nav class="bg-white border-b shadow-sm">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('dashboard') }}" class="font-semibold text-indigo-600">E-Learning TA</a>
            <div class="flex items-center gap-4 text-sm">
                <span class="text-gray-500">
                    {{ auth()->user()->name }}
                    <span class="ml-1 px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded text-xs uppercase">
                        {{ auth()->user()->role }}
                    </span>
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-red-600 hover:underline">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    @endauth

    <main class="max-w-5xl mx-auto px-4 py-8">
        @if (session('status'))
            <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
