<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Implementasi awal dari ELIW-03 (Mengelola data pengguna) dan
     * use case scenario "Mengelola Pengguna" (C200 Tabel 2.8).
     * Fungsionalitas CRUD penuh dilengkapi lagi di Fase 4.
     */
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->filled('role'), fn ($q) => $q->where('role', $request->role))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function approve(User $user)
    {
        abort_if($user->role !== 'teacher', 400, 'Hanya akun guru yang memerlukan approval.');

        $user->update(['status' => 'active']);

        return back()->with('status', "Akun guru \"{$user->name}\" berhasil diaktifkan.");
    }

    public function reject(User $user)
    {
        abort_if($user->role !== 'teacher', 400, 'Hanya akun guru yang memerlukan approval.');

        $user->update(['status' => 'inactive']);

        return back()->with('status', "Akun guru \"{$user->name}\" ditolak/dinonaktifkan.");
    }
}
