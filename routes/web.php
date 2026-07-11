<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;

//Admin
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\ParentStudentController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;


//Guru
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\CourseController;
use App\Http\Controllers\Teacher\GradeController;
use App\Http\Controllers\Teacher\ReportCardController;
use App\Http\Controllers\Teacher\AnnouncementController as TeacherAnnouncementController;

//Murid
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;

//Wali Murid
use App\Http\Controllers\ParentPortal\DashboardController as ParentDashboardController;
use App\Http\Controllers\ParentPortal\StudentController as ParentStudentDetailController;


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Route Fase 3 -- Autentikasi, RBAC & Checkpoint Testing
|--------------------------------------------------------------------------
| Gabungkan isi file ini ke routes/web.php project kamu.
| Kalau routes/web.php sudah ada isi bawaan Laravel (welcome page dsb),
| replace saja "/" nya dengan redirect ke login seperti di bawah.
*/

Route::get('/', fn () => redirect()->route('login'));

// ================= Guest only =================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ================= Authenticated (semua role) =================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    
    // ---------- Admin ----------
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        //Akademik
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('users.reject');
                
        Route::resource('academic-years', AcademicYearController::class);
        Route::post('academic-years/{academic_year}/activate', [AcademicYearController::class, 'activate'])
            ->name('academic-years.activate');

        Route::resource('semesters', SemesterController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('classes', SchoolClassController::class);
        Route::resource('schedules', ScheduleController::class);
        Route::resource('rooms', RoomController::class);

        Route::get('students', [AdminStudentController::class, 'index'])->name('students.index');
        Route::get('students/{student}/edit', [AdminStudentController::class, 'edit'])->name('students.edit');
        Route::put('students/{student}', [AdminStudentController::class, 'update'])->name('students.update');
        Route::get('parent-links', [ParentStudentController::class, 'index'])->name('parent-links.index');
        Route::get('parent-links/create', [ParentStudentController::class, 'create'])->name('parent-links.create');
        Route::post('parent-links', [ParentStudentController::class, 'store'])->name('parent-links.store');
        Route::delete('parent-links/{parentLink}', [ParentStudentController::class, 'destroy'])->name('parent-links.destroy');
        Route::resource('announcements', AdminAnnouncementController::class)->only(['index', 'create', 'store', 'destroy']);

    });

    // ---------- Guru ----------
    Route::middleware('role:teacher')->prefix('guru')->name('teacher.')->group(function () {
        Route::get('/dashboard', [TeacherDashboardController::class, 'index'])->name('dashboard');

        Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
        Route::post('/courses/sync', [CourseController::class, 'sync'])->name('courses.sync');

        Route::get('/courses/{course}/grades', [GradeController::class, 'show'])->name('grades.show');
        Route::put('/courses/{course}/grades', [GradeController::class, 'update'])->name('grades.update');

        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('/attendance/{schedule}', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance/{schedule}', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance/{schedule}/recap', [AttendanceController::class, 'recap'])->name('attendance.recap');

        Route::get('/report-card', [ReportCardController::class, 'index'])->name('report-card.index');
        Route::get('/report-card/{class}/{student}', [ReportCardController::class, 'show'])->name('report-card.show');

        Route::get('announcements', [TeacherAnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('courses/{course}/announcements/create', [TeacherAnnouncementController::class, 'create'])->name('courses.announcements.create');
        Route::post('courses/{course}/announcements', [TeacherAnnouncementController::class, 'store'])->name('courses.announcements.store');
    });

    // ---------- Murid ----------
    Route::middleware('role:student')->prefix('murid')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
    });

    // ---------- Wali Murid ----------
    Route::middleware('role:parent')->prefix('wali')->name('parent.')->group(function () {
        Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');

        Route::get('students/{student}', [ParentStudentDetailController::class, 'show'])->name('students.show');
    });
});
