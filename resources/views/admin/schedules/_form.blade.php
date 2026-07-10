@if ($errors->any())
    <div class="px-4 py-3 rounded bg-red-100 text-red-700 text-sm">
        {{ $errors->first() }}
    </div>
@endif

<div>
    <label class="block text-sm font-medium mb-1">Kelas</label>
    <select name="class_id" required class="w-full border rounded px-3 py-2 text-sm">
        <option value="">— Pilih —</option>
        @foreach ($classes as $class)
            <option value="{{ $class->id }}"
                {{ (old('class_id', $schedule->class_id ?? '')) == $class->id ? 'selected' : '' }}>
                {{ $class->name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Mata Pelajaran</label>
    <select name="subject_id" required class="w-full border rounded px-3 py-2 text-sm">
        <option value="">— Pilih —</option>
        @foreach ($subjects as $subject)
            <option value="{{ $subject->id }}"
                {{ (old('subject_id', $schedule->subject_id ?? '')) == $subject->id ? 'selected' : '' }}>
                {{ $subject->name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Guru Pengampu</label>
    <select name="teacher_id" required class="w-full border rounded px-3 py-2 text-sm">
        <option value="">— Pilih —</option>
        @foreach ($teachers as $teacher)
            <option value="{{ $teacher->id }}"
                {{ (old('teacher_id', $schedule->teacher_id ?? '')) == $teacher->id ? 'selected' : '' }}>
                {{ $teacher->user->name ?? '-' }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Ruang (opsional)</label>
    <input type="text" name="room" value="{{ old('room', $schedule->room ?? '') }}"
           placeholder="contoh: R.201" class="w-full border rounded px-3 py-2 text-sm">
</div>

<div>
    <label class="block text-sm font-medium mb-1">Hari</label>
    <select name="day" required class="w-full border rounded px-3 py-2 text-sm">
        <option value="">— Pilih —</option>
        @foreach ($days as $day)
            <option value="{{ $day }}" {{ old('day', $schedule->day ?? '') == $day ? 'selected' : '' }}>{{ $day }}</option>
        @endforeach
    </select>
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Jam Mulai</label>
        <input type="time" name="start_time" value="{{ old('start_time', isset($schedule) ? substr($schedule->start_time, 0, 5) : '') }}"
               required class="w-full border rounded px-3 py-2 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Jam Selesai</label>
        <input type="time" name="end_time" value="{{ old('end_time', isset($schedule) ? substr($schedule->end_time, 0, 5) : '') }}"
               required class="w-full border rounded px-3 py-2 text-sm">
    </div>
</div>
