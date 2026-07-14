@extends('layouts.app')

@section('title', 'Hubungkan Anak')

@section('content')
<div class="max-w-sm mx-auto bg-white p-6 rounded-lg shadow mt-10">
    <h1 class="text-xl font-semibold mb-1">Hubungkan ke Anak</h1>
    <p class="text-sm text-gray-500 mb-6">
        Masukkan kode unik anak Anda (didapat dari sekolah/admin). Satu anak bisa dihubungkan ke lebih dari satu wali murid.
    </p>

    @if ($errors->any())
        <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-700 text-sm">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('parent.link.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium mb-1">Kode Murid</label>
            <input type="text" name="code" required autofocus placeholder="contoh: A1B2C3D4"
                   class="w-full border rounded px-3 py-2 text-sm uppercase">
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded text-sm font-medium hover:bg-indigo-700">
            Hubungkan
        </button>
    </form>

    <p class="text-sm text-gray-500 mt-4 text-center">
        <a href="{{ route('parent.dashboard') }}" class="text-indigo-600 hover:underline">← Kembali ke Dashboard</a>
    </p>
</div>
@endsection
