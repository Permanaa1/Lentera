@extends('layouts.app')
@section('title', 'Hubungkan Anak')
@section('content')
<div class="min-h-[70vh] flex items-center justify-center">
    <div class="w-full max-w-sm">
        <div class="text-center mb-6">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-primary flex items-center justify-center text-secondary font-bold text-xl shadow-md">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <h1 class="mt-3 text-lg font-semibold text-gray-800">Hubungkan ke Anak</h1>
            <p class="text-sm text-gray-500 px-4">
                Masukkan kode unik anak Anda (didapat dari sekolah/admin).
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sm:p-8">
            @if ($errors->any())
                <div class="bg-danger-subtle border-l-4 border-danger text-danger rounded-r-lg px-4 py-3 text-sm mb-4">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('parent.link.store') }}" class="space-y-4">
                @csrf
                <x-input name="code" label="Kode Murid" placeholder="contoh: A1B2C3D4" required class="uppercase" />
                <x-button type="submit" variant="primary" class="w-full">Hubungkan</x-button>
            </form>
        </div>

        <p class="text-sm text-gray-500 mt-5 text-center">
            <a href="{{ route('parent.dashboard') }}" class="text-primary font-medium hover:underline">← Kembali ke Dashboard</a>
        </p>
    </div>
</div>
@endsection
