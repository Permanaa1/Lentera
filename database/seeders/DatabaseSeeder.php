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
     * Seeder data uji coba komprehensif untuk checkpoint testing Fase 1-4, 8, 9, 10.
     * Password SEMUA akun: "password"
     *
     * WAJIB jalankan via: php artisan migrate:fresh --seed
     * (bukan migrate biasa, karena ini mengisi ulang semuanya dari nol)
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

        $this->command->info('== 2/12: Jurusan, Ruang Kelas, Mata Pelajaran ==');

        // PERUBAHAN: Hanya mengubah list nama dan kode jurusan
        $departments = collect(['TMI', 'TKR', 'TSM', 'PPLG'])->map(fn ($code) => Department::create([
            'code' => $code,
            'name' => match ($code) {
                'TMI' => 'Teknik Mekanik Industri',
                'TKR' => 'Teknik Kendaraan Ringan',
                'TSM' => 'Teknik Sepeda Motor',
                'PPLG' => 'Pengembangan Perangkat Lunak & Gim',
            },
        ]));

        $rooms = collect(range(101, 106))->map(fn ($num) => Room::create([
            'code' => "R{$num}",
            'name' => "Ruang {$num}",
            'capacity' => 36,
        ]));

        // Dikembalikan seperti aslinya agar logika seeder tidak error
        $subjectData = [
            ['MTK', 'Matematika Wajib', 4],
            ['BIN', 'Bahasa Indonesia', 4],
            ['BIG', 'Bahasa Inggris', 3],
            ['FIS', 'Fisika', 3],
            ['KIM', 'Kimia', 3],
            ['BIO', 'Biologi', 3],
            ['SEJ', 'Sejarah Indonesia', 2],
            ['PJK', 'PJOK', 2],
        ];
        $subjects = collect($subjectData)->map(fn ($s) => Subject::create([
            'code' => $s[0],
            'name' => $s[1],
            'credit' => $s[2],
        ]));

        $this->command->info('== 3/12: Guru (10 akun) ==');

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
                'specialization' => $subjects[($i - 1) % $subjects->count()]->name,
            ]));
        }

        $this->command->info('== 4/12: Kelas (Rombel) ==');

        // PERUBAHAN: Hanya mengubah nama kelas menyesuaikan jurusan di atas.
        // Jumlah tetap 6 array agar kode aslinya tidak error.
        $classDefs = [
            ['X TMI 1', 'TMI'],
            ['X TKR 1', 'TKR'],
            ['X TSM 1', 'TSM'],
            ['XI PPLG 1', 'PPLG'],
            ['XI TMI 1', 'TMI'],
            ['XII TKR 1', 'TKR'],
        ];
        $classes = collect();
        foreach ($classDefs as $i => [$name, $deptCode]) {
            $dept = $departments->firstWhere('code', $deptCode);

            $classes->push(SchoolClass::create([
                'name' => $name,
                'department_id' => $dept->id,
                'academic_year_id' => $academicYear->id,
                'homeroom_teacher_id' => $teachers[$i % $teachers->count()]->id,
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

        $this->command->info('== 7/12: Jadwal Pelajaran ==');

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $schedules = collect();
        foreach ($classes as $ci => $class) {
            foreach ($days as $di => $day) {
                $subject = $subjects[($ci + $di) % $subjects->count()];
                $teacher = $teachers[($ci + $di) % $teachers->count()];
                $room = $rooms[($ci + $di) % $rooms->count()];

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

        $this->command->warn('Catatan: jadwal di-generate langsung ke DB (bukan lewat form), jadi TIDAK melalui validasi bentrok. Wajar kalau ada kombinasi guru/ruang yang kebetulan bentrok -- tidak masalah untuk data uji coba.');

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
                'Kuis Minggu Depan',
                'Akan ada kuis dadakan minggu depan, silakan pelajari materi terakhir.',
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
            ['Guru', 'guru1@elearning.test', 'Wali kelas X TMI 1, punya course, jadwal, nilai & absensi terisi'],
            ['Murid', 'murid1@elearning.test', 'Di kelas X TMI 1, sudah ada nilai & absensi'],
            ['Wali Murid', 'wali1@elearning.test', 'Terhubung ke murid1'],
            ['Wali Murid', 'wali29@elearning.test', 'SENGAJA belum terhubung ke anak manapun'],
            ['Wali Murid', 'wali30@elearning.test', 'SENGAJA belum terhubung ke anak manapun'],
        ]);
        $this->command->info('50 murid: murid1..murid50 | 10 guru: guru1..guru10 | 30 wali: wali1..wali30');
        $this->command->info('===================================================');
    }
}
