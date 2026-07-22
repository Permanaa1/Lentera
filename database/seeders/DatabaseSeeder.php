<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Course;
use App\Models\Department;
use App\Models\Grade;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\ParentUser;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seeder data uji coba komprehensif -- versi SMK.
     * Password SEMUA akun: "password"
     *
     * WAJIB jalankan via: php artisan migrate:fresh --seed
     */
    public function run(): void
    {
        $faker = fake('id_ID');

        $this->command->info('== 1/12: Admin & Struktur Akademik Dasar ==');

        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@elearning.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $academicYear = AcademicYear::create([
            'name' => '2026/2027',
            'start_date' => '2026-07-01',
            'end_date' => '2027-06-30',
            'is_active' => true,
        ]);

        $semesterGanjil = Semester::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'Ganjil',
            'start_date' => '2026-07-01',
            'end_date' => '2026-12-31',
        ]);

        Semester::create([
            'academic_year_id' => $academicYear->id,
            'name' => 'Genap',
            'start_date' => '2027-01-01',
            'end_date' => '2027-06-30',
        ]);

        $this->command->info('== 2/12: Jurusan (Konsentrasi Keahlian SMK), Ruang, Mata Pelajaran ==');

        $departmentData = [
            ['TMI', 'Teknik Mekanik Industri'],
            ['TKR', 'Teknik Kendaraan Ringan'],
            ['TSM', 'Teknik Sepeda Motor'],
            ['PPLG', 'Pengembangan Perangkat Lunak dan Gim'],
        ];
        $departments = collect($departmentData)->map(fn ($d) => Department::create([
            'code' => $d[0],
            'name' => $d[1],
        ]));

        // Ruang teori umum + bengkel/lab per jurusan (lebih representatif untuk SMK
        // dibanding "R101, R102, ..." generik).
        $roomData = [
            ['R101', 'Ruang Teori 101', 36],
            ['R102', 'Ruang Teori 102', 36],
            ['BTMI', 'Bengkel Teknik Mekanik Industri', 24],
            ['BTKR', 'Bengkel Teknik Kendaraan Ringan', 24],
            ['BTSM', 'Bengkel Teknik Sepeda Motor', 24],
            ['LPPLG', 'Lab Komputer PPLG', 30],
        ];
        $rooms = collect($roomData)->map(fn ($r) => Room::create([
            'code' => $r[0], 'name' => $r[1], 'capacity' => $r[2],
        ]));

        // Mapel Normatif/Adaptif (dept = null, dipelajari semua jurusan) +
        // Mapel Produktif (dept = kode jurusan, cuma dipelajari jurusan itu).
        // Catatan: kolom "dept" ini TIDAK disimpan ke DB (tabel subjects tidak
        // punya department_id di skema kita) -- cuma dipakai di seeder ini untuk
        // menentukan mapel & guru mana yang masuk ke jadwal kelas jurusan mana.
        $subjectData = [
            ['MTK', 'Matematika', 4, null],
            ['BIN', 'Bahasa Indonesia', 4, null],
            ['BIG', 'Bahasa Inggris', 3, null],
            ['PKN', 'Pendidikan Pancasila', 2, null],
            ['PJK', 'PJOK', 2, null],
            ['TPM', 'Teknik Pemesinan Dasar', 4, 'TMI'],
            ['GTK', 'Gambar Teknik', 3, 'TMI'],
            ['MOT', 'Motor Otomotif', 4, 'TKR'],
            ['SKL', 'Sistem Kelistrikan Kendaraan', 3, 'TKR'],
            ['TSD', 'Teknik Sepeda Motor Dasar', 4, 'TSM'],
            ['CSM', 'Chasis dan Suspensi Sepeda Motor', 3, 'TSM'],
            ['PDS', 'Pemrograman Dasar', 4, 'PPLG'],
            ['BDT', 'Basis Data', 3, 'PPLG'],
            ['DGM', 'Desain Grafis dan Multimedia', 3, 'PPLG'],
        ];
        $subjects = collect($subjectData)->map(fn ($s) => Subject::create([
            'code' => $s[0], 'name' => $s[1], 'credit' => $s[2],
        ]));
        $subjectByCode = $subjects->keyBy('code');
        $deptTagByCode = collect($subjectData)->mapWithKeys(fn ($s) => [$s[0] => $s[3]]);

        $generalCodes = collect(['MTK', 'BIN', 'BIG', 'PKN', 'PJK']);
        $productiveByDept = collect($subjectData)
            ->filter(fn ($s) => $s[3] !== null)
            ->groupBy(fn ($s) => $s[3])
            ->map(fn ($group) => $group->pluck(0)->values());

        $this->command->info('== 3/12: Guru (10 akun, 5 umum + 5 produktif per jurusan) ==');

        // Selaraskan spesialisasi guru dengan mapel: index 0-4 guru umum,
        // index 5-9 guru produktif (mengampu 1-2 mapel serumpun per jurusan --
        // wajar di SMK, 1 guru produktif sering mengampu beberapa mapel jurusannya).
        $teacherSpecs = [
            'Matematika',
            'Bahasa Indonesia',
            'Bahasa Inggris',
            'Pendidikan Pancasila',
            'PJOK',
            'Teknik Pemesinan Dasar & Gambar Teknik (TMI)',
            'Motor Otomotif & Sistem Kelistrikan Kendaraan (TKR)',
            'Teknik Sepeda Motor Dasar & Chasis (TSM)',
            'Pemrograman Dasar & Basis Data (PPLG)',
            'Desain Grafis dan Multimedia (PPLG)',
        ];

        $teacherForSubjectCode = [
            'MTK' => 0, 'BIN' => 1, 'BIG' => 2, 'PKN' => 3, 'PJK' => 4,
            'TPM' => 5, 'GTK' => 5,
            'MOT' => 6, 'SKL' => 6,
            'TSD' => 7, 'CSM' => 7,
            'PDS' => 8, 'BDT' => 8,
            'DGM' => 9,
        ];

        $teachers = collect();
        foreach (range(1, 10) as $i) {
            $user = User::create([
                'name' => $faker->name(),
                'email' => "guru{$i}@elearning.test",
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'status' => 'active',
            ]);

            $teachers->push(Teacher::create([
                'user_id' => $user->id,
                'nip' => '19800' . str_pad($i, 2, '0', STR_PAD_LEFT) . '2010011' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'specialization' => $teacherSpecs[$i - 1],
            ]));
        }

        $this->command->info('== 4/12: Kelas (Rombel) per Konsentrasi Keahlian ==');

        // PPLG sengaja dapat 3 tingkat (X, XI, XII) karena jurusan ini paling relevan
        // dengan tema TA kamu sendiri (software) -- jurusan lain cukup 1 kelas (X) dulu.
        $classDefs = [
            ['X TMI 1', 'TMI', 10],
            ['X TKR 1', 'TKR', 10],
            ['X TSM 1', 'TSM', 10],
            ['X PPLG 1', 'PPLG', 10],
            ['XI PPLG 1', 'PPLG', 11],
            ['XII PPLG 1', 'PPLG', 12],
        ];
        // Wali kelas: guru produktif jurusan terkait (lazim di SMK -- wali kelas
        // jurusan biasanya dari guru produktif jurusan itu sendiri).
        $homeroomTeacherIndex = [5, 6, 7, 8, 9, 8];

        $classes = collect();
        foreach ($classDefs as $i => [$name, $deptCode, $tingkat]) {
            $dept = $departments->firstWhere('code', $deptCode);
            $classes->push(SchoolClass::create([
                'name' => $name,
                'tingkat' => $tingkat,
                'department_id' => $dept->id,
                'academic_year_id' => $academicYear->id,
                'homeroom_teacher_id' => $teachers[$homeroomTeacherIndex[$i]]->id,
            ]));
        }
        

        $this->command->info('== 5/12: Murid (50 akun, dibagi ke 6 kelas) ==');

        $students = collect();
        foreach (range(1, 50) as $i) {
            $user = User::create([
                'name' => $faker->name(),
                'email' => "murid{$i}@elearning.test",
                'password' => Hash::make('password'),
                'role' => 'student',
                'status' => 'active',
            ]);

            $students->push(Student::create([
                'user_id' => $user->id,
                'class_id' => $classes[$i % $classes->count()]->id,
                'nis' => '2026' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'academic_status' => 'active',
            ]));
        }

        $this->command->info('== 6/12: Wali Murid (30 akun) + hubungkan ke anak ==');

        $parents = collect();
        foreach (range(1, 30) as $i) {
            $user = User::create([
                'name' => $faker->name(),
                'email' => "wali{$i}@elearning.test",
                'password' => Hash::make('password'),
                'role' => 'parent',
                'status' => 'active',
            ]);

            $parents->push(ParentUser::create(['user_id' => $user->id]));
        }

        $studentPool = $students->take(45)->values();
        $cursor = 0;
        foreach ($parents->take(25) as $parent) {
            $parent->linkStudent($studentPool[$cursor]);
            $cursor++;
        }
        foreach ($parents->slice(25, 3) as $parent) {
            $parent->linkStudent($studentPool[$cursor]);
            $cursor++;
            $parent->linkStudent($studentPool[$cursor]);
            $cursor++;
        }
        // 2 wali murid terakhir & 5 murid terakhir sengaja tidak dihubungkan (tes edge case).

        $this->command->info('== 7/12: Jadwal Pelajaran (produktif jurusan + normatif/adaptif) ==');

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $roomForDept = ['TMI' => 'BTMI', 'TKR' => 'BTKR', 'TSM' => 'BTSM', 'PPLG' => 'LPPLG'];

        $schedules = collect();
        foreach ($classes as $ci => $class) {
            $deptCode = $classDefs[$ci][1];
            $productiveCodes = $productiveByDept->get($deptCode, collect());

            // Susun 5 mapel/minggu: mapel produktif jurusan diprioritaskan,
            // sisa slot diisi mapel normatif/adaptif umum.
            $weekCodes = $productiveCodes->concat($generalCodes)->take(5)->values();

            foreach ($days as $di => $day) {
                $code = $weekCodes[$di];
                $subject = $subjectByCode[$code];
                $teacher = $teachers[$teacherForSubjectCode[$code]];

                $isProductive = $deptTagByCode[$code] !== null;
                $roomCode = $isProductive ? $roomForDept[$deptTagByCode[$code]] : ($di % 2 === 0 ? 'R101' : 'R102');
                $room = $rooms->firstWhere('code', $roomCode);

                $schedules->push(Schedule::create([
                    'class_id' => $class->id,
                    'subject_id' => $subject->id,
                    'teacher_id' => $teacher->id,
                    'room_id' => $room->id,
                    'day' => $day,
                    'start_time' => '07:00',
                    'end_time' => '08:30',
                ]));
            }
        }

        $this->command->warn('Catatan: jadwal di-generate langsung ke DB, TIDAK melalui validasi bentrok form. Untuk data 6 kelas x 5 hari dengan guru produktif per-jurusan seperti ini, seharusnya tidak ada bentrok guru (tiap guru cuma dipakai jurusannya sendiri) -- tapi tetap uji manual via form kalau mau benar-benar memastikan validasinya jalan.');

        $this->command->info('== 8/12: Course (mengikuti pola "sync dari jadwal" Fase 8) ==');

        $courses = collect();
        foreach ($schedules as $s) {
            $courses->push(Course::create([
                'class_id' => $s->class_id,
                'subject_id' => $s->subject_id,
                'teacher_id' => $s->teacher_id,
                'semester_id' => $semesterGanjil->id,
                'title' => $s->subject->name . ' - ' . $s->schoolClass->name,
            ]));
        }

        $this->command->info('== 9/12: Nilai ==');

        foreach ($courses as $course) {
            $classStudents = $students->where('class_id', $course->class_id);

            foreach ($classStudents as $student) {
                $grade = Grade::create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'assignment_score' => rand(65, 95),
                    'quiz_score' => rand(60, 95),
                    'exam_score' => rand(60, 95),
                ]);
                $grade->calculateFinalScore();
            }
        }

        $this->command->info('== 10/12: Absensi (2 pertemuan terakhir per jadwal) ==');

        $statusPool = ['present', 'present', 'present', 'present', 'sick', 'permission', 'absent'];
        foreach ($schedules as $schedule) {
            $classStudents = $students->where('class_id', $schedule->class_id);

            foreach ([now()->subWeek(), now()->subWeeks(2)] as $date) {
                foreach ($classStudents as $student) {
                    Attendance::markAttendance(
                        studentId: $student->id,
                        date: $date->toDateString(),
                        status: $statusPool[array_rand($statusPool)],
                        scheduleId: $schedule->id,
                    );
                }
            }
        }

        $this->command->info('== 11/12: Tagihan & Pembayaran ==');

        foreach ($students as $i => $student) {
            $invoice = Invoice::generateInvoice($student->id, 'spp', 350000, now()->addDays(14)->toDateString());

            $bucket = $i % 5;
            if ($bucket >= 2 && $bucket <= 3) {
                Payment::create([
                    'invoice_id' => $invoice->id,
                    'payment_date' => now()->subDays(rand(1, 10)),
                    'amount' => $invoice->amount,
                    'payment_method' => 'Transfer Bank',
                    'transaction_number' => 'TRX' . strtoupper(Str::random(8)),
                    'status' => 'verified',
                ]);
                $invoice->markAsPaid();
            } elseif ($bucket === 4) {
                Payment::create([
                    'invoice_id' => $invoice->id,
                    'payment_date' => now()->subDays(rand(1, 3)),
                    'amount' => $invoice->amount,
                    'payment_method' => 'Transfer Bank',
                    'transaction_number' => 'TRX' . strtoupper(Str::random(8)),
                    'status' => 'pending',
                ]);
            }
        }

        $this->command->info('== 12/12: Pengumuman & Notifikasi ==');

        Announcement::create([
            'created_by' => $admin->id,
            'title' => 'Libur Semester Ganjil',
            'content' => 'Libur semester ganjil dimulai tanggal 20 Desember 2026.',
            'target_role' => 'all',
        ]);

        Announcement::create([
            'created_by' => $admin->id,
            'title' => 'Pembayaran SPP Bulan Ini',
            'content' => 'Mohon segera lunasi SPP sebelum tanggal jatuh tempo.',
            'target_role' => 'parent',
        ]);

        if ($courses->isNotEmpty()) {
            $firstCourse = $courses->first();
            $firstCourse->publishAnnouncement(
                'Praktik Minggu Depan',
                'Akan ada sesi praktik tambahan minggu depan, harap membawa perlengkapan sesuai instruksi.',
                $firstCourse->teacher->user_id
            );
        }

        foreach ($students->take(10) as $student) {
            Notification::create([
                'user_id' => $student->user_id,
                'title' => 'Nilai baru diinput',
                'message' => 'Nilai salah satu mata pelajaran Anda sudah diinput guru.',
                'is_read' => false,
            ]);
        }

        $this->command->info('===================================================');
        $this->command->info('SEEDING SELESAI. Password SEMUA akun: "password"');
        $this->command->table(['Role', 'Email', 'Catatan'], [
            ['Admin', 'admin@elearning.test', '-'],
            ['Guru', 'guru6@elearning.test', 'Guru produktif TMI, wali kelas X TMI 1'],
            ['Guru', 'guru9@elearning.test', 'Guru produktif PPLG, wali kelas X & XII PPLG 1'],
            ['Murid', 'murid4@elearning.test', 'Di kelas X PPLG 1 (index 4 dari 6 kelas)'],
            ['Wali Murid', 'wali1@elearning.test', 'Terhubung ke murid1'],
            ['Wali Murid', 'wali29@elearning.test', 'SENGAJA belum terhubung ke anak manapun'],
        ]);
        $this->command->info('4 Jurusan: TMI, TKR, TSM, PPLG | 6 Kelas | 50 murid | 10 guru | 30 wali');
        $this->command->info('===================================================');
    }
}