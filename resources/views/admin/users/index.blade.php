@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('admin-content')
<h1 class="text-xl font-semibold mb-6">Kelola Pengguna</h1>

<form method="GET" class="flex gap-3 mb-4 text-sm">
    <select name="role" class="border rounded px-2 py-1" onchange="this.form.submit()">
        <option value="">Semua Role</option>
        @foreach (['admin', 'teacher', 'student', 'parent'] as $r)
            <option value="{{ $r }}" {{ request('role') == $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
        @endforeach
    </select>
    <select name="status" class="border rounded px-2 py-1" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        @foreach (['pending', 'active', 'inactive'] as $s)
            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
</form>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Role</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2 uppercase text-xs">{{ $user->role }}</td>
                    <td class="px-4 py-2">
                        <span @class([
                            'px-2 py-0.5 rounded text-xs',
                            'bg-yellow-100 text-yellow-800' => $user->status === 'pending',
                            'bg-green-100 text-green-800' => $user->status === 'active',
                            'bg-gray-200 text-gray-600' => $user->status === 'inactive',
                        ])>
                            {{ $user->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        @if ($user->role === 'teacher' && $user->status === 'pending')
                            <form method="POST" action="{{ route('admin.users.approve', $user) }}" class="inline">
                                @csrf
                                <button class="text-green-600 hover:underline mr-2">Approve</button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.reject', $user) }}" class="inline">
                                @csrf
                                <button class="text-red-600 hover:underline">Tolak</button>
                            </form>
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-400">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $users->links() }}</div>
@endsection
