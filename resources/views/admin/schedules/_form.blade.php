@if ($errors->any())
    <div class="bg-danger-subtle border-l-4 border-danger text-danger rounded-r-lg px-4 py-3 text-sm">
        {{ $errors->first() }}
    </div>
@endif

<x-select name="class_id" label="Kelas" required>
    <option value="">— Pilih —</option>
    @foreach ($classes as $class)
        <option value="{{ $class->id }}" {{ (old('class_id', $schedule->class_id ?? '')) == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
    @endforeach
</x-select>

<x-select name="subject_id" label="Mata Pelajaran" required>
    <option value="">— Pilih —</option>
    @foreach ($subjects as $subject)
        <option value="{{ $subject->id }}" {{ (old('subject_id', $schedule->subject_id ?? '')) == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
    @endforeach
</x-select>

<x-select name="teacher_id" label="Guru Pengampu" required>
    <option value="">— Pilih —</option>
    @foreach ($teachers as $teacher)
        <option value="{{ $teacher->id }}" {{ (old('teacher_id', $schedule->teacher_id ?? '')) == $teacher->id ? 'selected' : '' }}>{{ $teacher->user->name ?? '-' }}</option>
    @endforeach
</x-select>

<x-select name="room_id" label="Ruang (opsional)">
    <option value="">— Tidak ada —</option>
    @foreach ($rooms as $room)
        <option value="{{ $room->id }}" {{ (old('room_id', $schedule->room_id ?? '')) == $room->id ? 'selected' : '' }}>{{ $room->code }} — {{ $room->name }}</option>
    @endforeach
</x-select>

<x-select name="day" label="Hari" required>
    <option value="">— Pilih —</option>
    @foreach ($days as $day)
        <option value="{{ $day }}" {{ old('day', $schedule->day ?? '') == $day ? 'selected' : '' }}>{{ $day }}</option>
    @endforeach
</x-select>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
    <x-input type="time" name="start_time" label="Jam Mulai" :value="isset($schedule) ? substr($schedule->start_time, 0, 5) : ''" required />
    <x-input type="time" name="end_time" label="Jam Selesai" :value="isset($schedule) ? substr($schedule->end_time, 0, 5) : ''" required />
</div>
