@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('admin-content')
<x-page-header title="Kelola Pengguna" subtitle="Semua akun terdaftar di sistem, termasuk persetujuan akun guru." />

<form method="GET" class="flex flex-wrap gap-2 mb-4 text-sm">
    <select name="role" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
        <option value="">Semua Role</option>
        @foreach (['admin', 'teacher', 'student', 'parent'] as $r)
            <option value="{{ $r }}" {{ request('role') == $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
        @endforeach
    </select>
    <select name="status" onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-primary/20">
        <option value="">Semua Status</option>
        @foreach (['pending', 'active', 'inactive'] as $s)
            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
</form>

<x-table-wrapper>
    <table class="responsive-table w-full text-sm min-w-[560px]">
        <thead class="bg-gray-50 text-left">
            <tr>
                <th class="px-4 py-3 font-semibold text-gray-600">Nama</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Email</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Role</th>
                <th class="px-4 py-3 font-semibold text-gray-600">Status</th>
                <th class="px-4 py-3 font-semibold text-gray-600 w-40">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($users as $user)
                <tr class="hover:bg-surface/60 transition">
                    <td data-label="Nama" class="px-4 py-3 font-medium text-gray-800">{{ $user->name }}</td>
                    <td data-label="Email" class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                    <td data-label="Role" class="px-4 py-3">
                        <x-badge color="primary">{{ $user->role }}</x-badge>
                    </td>
                    <td data-label="Status" class="px-4 py-3">
                        <x-badge :color="match($user->status) { 'active' => 'success', 'pending' => 'warning', default => 'gray' }">
                            {{ $user->status }}
                        </x-badge>
                    </td>
                    <td data-label="Aksi" class="px-4 py-3">
                        @if ($user->role === 'teacher' && $user->status === 'pending')
                            <div class="flex gap-3 justify-end sm:justify-start">
                                <form method="POST" action="{{ route('admin.users.approve', $user) }}">
                                    @csrf
                                    <button class="text-success hover:underline text-sm font-medium">Approve</button>
                                </form>
                                <form method="POST" action="{{ route('admin.users.reject', $user) }}">
                                    @csrf
                                    <button class="text-danger hover:underline text-sm font-medium">Tolak</button>
                                </form>
                            </div>
                        @else
                            <span class="text-gray-300">—</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5"><x-empty-state message="Belum ada pengguna dengan filter ini." /></td></tr>
            @endforelse
        </tbody>
    </table>
</x-table-wrapper>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
