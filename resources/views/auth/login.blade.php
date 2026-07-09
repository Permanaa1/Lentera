@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="max-w-sm mx-auto bg-white p-6 rounded-lg shadow mt-10">
    <h1 class="text-xl font-semibold mb-1">Masuk ke Sistem</h1>
    <p class="text-sm text-gray-500 mb-6">Login sebagai Admin, Guru, Murid, atau Wali Murid.</p>

    @if ($errors->any())
        <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-700 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember"> Ingat saya
        </label>
        <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded text-sm font-medium hover:bg-indigo-700">
            Login
        </button>
    </form>

    <p class="text-sm text-gray-500 mt-4 text-center">
        Belum punya akun? <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Daftar</a>
    </p>
</div>
@endsection
