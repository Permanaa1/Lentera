<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Implementasi ELIW-10 (Mengelola data ruang kelas) -- semula ditunda,
    // dinaikkan prioritasnya karena dibutuhkan untuk validasi bentrok ruang di modul Jadwal.

    public function index()
    {
        $rooms = Room::withCount('schedules')->orderBy('code')->paginate(10);

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:rooms,code'],
            'name' => ['required', 'string', 'max:100'],
            'capacity' => ['nullable', 'integer', 'min:1'],
        ]);

        Room::create($data);

        return redirect()->route('admin.rooms.index')
            ->with('status', 'Ruang kelas berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:rooms,code,' . $room->id],
            'name' => ['required', 'string', 'max:100'],
            'capacity' => ['nullable', 'integer', 'min:1'],
        ]);

        $room->update($data);

        return redirect()->route('admin.rooms.index')
            ->with('status', 'Ruang kelas berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        if ($room->schedules()->exists()) {
            return back()->with('status', 'Tidak bisa menghapus ruang yang masih dipakai jadwal.');
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('status', 'Ruang kelas berhasil dihapus.');
    }
}
