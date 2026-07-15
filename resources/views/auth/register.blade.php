@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-[75vh] flex items-center justify-center py-6">
    <div class="w-full max-w-md">
        <div class="text-center mb-6">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-primary flex items-center justify-center text-secondary font-bold text-xl shadow-md">
                E
            </div>
            <h1 class="mt-3 text-lg font-semibold text-gray-800">Daftar Akun Baru</h1>
            <p class="text-sm text-gray-500 px-4">
                Akun Guru butuh persetujuan admin sebelum bisa login. Murid & Wali Murid langsung aktif.
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-8">
            @if ($errors->any())
                <x-alert type="danger" class="mb-4">
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </x-alert>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4"
                  x-data="{ role: '{{ old('role', 'student') }}' }">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Daftar sebagai</label>
                    <select name="role" x-model="role"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Murid</option>
                        <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Guru</option>
                        <option value="parent" {{ old('role') == 'parent' ? 'selected' : '' }}>Wali Murid</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                </div>

                <div x-show="role === 'student'" x-cloak>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                </div>

                <div x-show="role === 'teacher'" x-cloak>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                    <input type="text" name="nip" value="{{ old('nip') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" required minlength="8"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required minlength="8"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                </div>

                <x-button type="submit" variant="primary" class="w-full py-2.5">
                    Daftar
                </x-button>
            </form>
        </div>

        <p class="text-sm text-gray-500 mt-5 text-center">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Login</a>
        </p>
    </div>
</div>
@endsection
