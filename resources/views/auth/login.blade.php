@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center">
    <div class="w-full max-w-md">
        <div class="text-center mb-6">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-primary flex items-center justify-center text-secondary font-bold text-xl shadow-md">
                E
            </div>
            <h1 class="mt-3 text-lg font-semibold text-gray-800">Sistem Akademik & E-Learning</h1>
            <p class="text-sm text-gray-500">Masuk untuk melanjutkan</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-8">
            @if ($errors->any())
                <x-alert type="danger" class="mb-4">{{ $errors->first() }}</x-alert>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition">
                </div>
                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary focus:ring-primary">
                    Ingat saya
                </label>
                <x-button type="submit" variant="primary" class="w-full py-2.5">
                    Login
                </x-button>
            </form>
        </div>

        <p class="text-sm text-gray-500 mt-5 text-center">
            Belum punya akun? <a href="{{ route('register') }}" class="text-primary font-medium hover:underline">Daftar</a>
        </p>
    </div>
</div>
@endsection
