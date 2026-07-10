<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    // Implementasi SRS-40 (manageSchedule) & SRS-41 (assignTeacherLoad) / ELIW-lain terkait jadwal.
    // assignTeacherLoad tercakup di sini karena penugasan guru mengajar terjadi
    // saat guru dipasangkan ke jadwal (class + subject + teacher).

    protected array $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    public function index(Request $request)
    {
        $schedules = Schedule::with('schoolClass', 'subject', 'teacher.user')
            ->when($request->filled('class_id'), fn ($q) => $q->where('class_id', $request->class_id))
            ->orderByRaw("FIELD(day, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('start_time')
            ->paginate(15)
            ->withQueryString();

        $classes = SchoolClass::orderBy('name')->get();

        return view('admin.schedules.index', compact('schedules', 'classes'));
    }

    public function create()
    {
        [$classes, $subjects, $teachers] = $this->formOptions();

        return view('admin.schedules.create', compact('classes', 'subjects', 'teachers'), ['days' => $this->days]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $this->assertNoConflict($data);

        Schedule::create($data);

        return redirect()->route('admin.schedules.index')
            ->with('status', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Schedule $schedule)
    {
        [$classes, $subjects, $teachers] = $this->formOptions();

        return view('admin.schedules.edit', compact('schedule', 'classes', 'subjects', 'teachers'), ['days' => $this->days]);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $this->validateData($request);

        $this->assertNoConflict($data, $schedule->id);

        $schedule->update($data);

        return redirect()->route('admin.schedules.index')
            ->with('status', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('status', 'Jadwal berhasil dihapus.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'class_id' => ['required', 'exists:classes,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['required', 'exists:teachers,id'],
            'room' => ['nullable', 'string', 'max:50'],
            'day' => ['required', 'in:' . implode(',', $this->days)],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);
    }

    /**
     * Cegah 3 jenis bentrok jadwal sekaligus:
     * 1. Guru yang sama tidak boleh mengajar 2 kelas di hari & jam yang tumpang tindih.
     * 2. Kelas yang sama tidak boleh punya 2 pelajaran di hari & jam yang tumpang tindih.
     * 3. Ruang yang sama (kalau diisi) tidak boleh dipakai 2 jadwal berbeda di jam yang tumpang tindih.
     *
     * Catatan soal poin 3: karena "room" masih kolom teks bebas (bukan tabel master
     * tersendiri -- lihat catatan Fase 4 soal Ruang Kelas), pengecekan ini rawan
     * lolos kalau penulisannya beda-beda (mis. "R.201" vs "R201" dianggap 2 ruang
     * berbeda). Begitu tabel `rooms` dibuat nanti, validasi ini idealnya diganti
     * membandingkan room_id, bukan string.
     *
     * ValidationException dipakai (bukan abort_if) supaya Laravel otomatis
     * redirect-back dengan pesan error tampil di form, bukan halaman error mentah.
     */
    protected function assertNoConflict(array $data, ?int $ignoreId = null): void
    {
        $overlap = function ($query) use ($data) {
            $query->where('day', $data['day'])
                  ->where(function ($q) use ($data) {
                      $q->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                        ->orWhereBetween('end_time', [$data['start_time'], $data['end_time']])
                        ->orWhere(function ($q2) use ($data) {
                            $q2->where('start_time', '<=', $data['start_time'])
                               ->where('end_time', '>=', $data['end_time']);
                        });
                  });
        };

        $teacherConflict = Schedule::where('teacher_id', $data['teacher_id'])
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where($overlap)
            ->exists();

        if ($teacherConflict) {
            throw ValidationException::withMessages([
                'teacher_id' => 'Guru ini sudah punya jadwal lain yang bentrok di hari & jam yang sama.',
            ]);
        }

        $classConflict = Schedule::where('class_id', $data['class_id'])
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->where($overlap)
            ->exists();

        if ($classConflict) {
            throw ValidationException::withMessages([
                'class_id' => 'Kelas ini sudah punya jadwal lain yang bentrok di hari & jam yang sama.',
            ]);
        }

        if (! empty($data['room'])) {
            $roomConflict = Schedule::where('room', $data['room'])
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->where($overlap)
                ->exists();

            if ($roomConflict) {
                throw ValidationException::withMessages([
                    'room' => "Ruang \"{$data['room']}\" sudah dipakai jadwal lain di hari & jam yang sama.",
                ]);
            }
        }
    }

    protected function formOptions(): array
    {
        return [
            SchoolClass::orderBy('name')->get(),
            Subject::orderBy('name')->get(),
            Teacher::with('user')->get(),
        ];
    }
}