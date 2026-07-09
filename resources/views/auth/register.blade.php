@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-sm mx-auto bg-white p-6 rounded-lg shadow mt-10">
    <h1 class="text-xl font-semibold mb-1">Daftar Akun Baru</h1>
    <p class="text-sm text-gray-500 mb-6">
        Akun Guru butuh persetujuan admin sebelum bisa login. Murid & Wali Murid langsung aktif.
    </p>

    @if ($errors->any())
        <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-700 text-sm">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{ role: '{{ old('role', 'student') }}' }">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Daftar sebagai</label>
            <select name="role" x-model="role" class="w-full border rounded px-3 py-2 text-sm">
                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Murid</option>
                <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Guru</option>
                <option value="parent" {{ old('role') == 'parent' ? 'selected' : '' }}>Wali Murid</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div x-show="role === 'student'">
            <label class="block text-sm font-medium mb-1">NIS</label>
            <input type="text" name="nis" value="{{ old('nis') }}"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div x-show="role === 'teacher'">
            <label class="block text-sm font-medium mb-1">NIP</label>
            <input type="text" name="nip" value="{{ old('nip') }}"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" required minlength="8"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required minlength="8"
                   class="w-full border rounded px-3 py-2 text-sm">
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded text-sm font-medium hover:bg-indigo-700">
            Daftar
        </button>
    </form>

    <p class="text-sm text-gray-500 mt-4 text-center">
        Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Login</a>
    </p>
</div>

{{-- Alpine.js dipakai cuma untuk show/hide field NIS/NIP sesuai role dipilih --}}
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
