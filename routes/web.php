<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ParentPortal\DashboardController as ParentDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Teacher\DashboardController as TeacherDashboardController;
use App\Http\Controllers\Admin\AcademicYearController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\SchoolClassController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\CourseController;
use App\Http\Controllers\Teacher\GradeController;
use App\Http\Controllers\Teacher\ReportCardController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\ParentStudentController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ParentPortal\StudentController as ParentStudentDetailController;
use App\Http\Controllers\Teacher\AnnouncementController as TeacherAnnouncementController;
use App\Http\Controllers\ParentPortal\LinkController;
use App\Http\Controllers\Student\AttendanceController as StudentAttendanceController;
use App\Http\Controllers\Student\GradeController as StudentGradeController;
use App\Http\Controllers\Student\InvoiceController as StudentInvoiceController;
use App\Http\Controllers\Student\PaymentController as StudentPaymentController;
use Illuminate\Support\Facades\Route;


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

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/approve', [AdminUserController::class, 'approve'])->name('users.approve');
        Route::post('/users/{user}/reject', [AdminUserController::class, 'reject'])->name('users.reject');

        Route::resource('academic-years', AcademicYearController::class);
        Route::post('academic-years/{academic_year}/activate', [AcademicYearController::class, 'activate'])
            ->name('academic-years.activate');

        //Akademik
        Route::resource('semesters', SemesterController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('classes', SchoolClassController::class);
        Route::resource('schedules', ScheduleController::class);
        Route::resource('rooms', RoomController::class);
        Route::get('schedules-calendar', [\App\Http\Controllers\Admin\ScheduleController::class, 'calendar'])
    ->name('schedules.calendar');


        //Payment
        Route::resource('invoices', InvoiceController::class)->except('edit', 'update');
        Route::get('invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
        Route::put('invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::get('invoices/{invoice}/payments/create', [PaymentController::class, 'create'])->name('invoices.payments.create');
        Route::post('invoices/{invoice}/payments', [PaymentController::class, 'store'])->name('invoices.payments.store');
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::post('payments/{payment}/verify', [PaymentController::class, 'verify'])->name('payments.verify');
        Route::post('payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');


        //parent-student
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
        Route::get('/attendance/{schedule}/class-recap', [\App\Http\Controllers\Teacher\AttendanceController::class, 'classRecap'])
    ->name('attendance.class-recap');

        Route::get('/report-card', [ReportCardController::class, 'index'])->name('report-card.index');
        Route::get('/report-card/{class}/{student}', [ReportCardController::class, 'show'])->name('report-card.show');

        Route::get('announcements', [TeacherAnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('courses/{course}/announcements/create', [TeacherAnnouncementController::class, 'create'])->name('courses.announcements.create');
        Route::post('courses/{course}/announcements', [TeacherAnnouncementController::class, 'store'])->name('courses.announcements.store');
    });

    // ---------- Murid ----------
    Route::middleware('role:student')->prefix('murid')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/grades', [StudentGradeController::class, 'index'])->name('grades.index');
        Route::get('/attendance', [StudentAttendanceController::class, 'index'])->name('attendance.index');

        Route::get('/invoices', [StudentInvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/invoices/{invoice}/pay', [StudentPaymentController::class, 'create'])->name('invoices.payments.create');
        Route::post('/invoices/{invoice}/pay', [StudentPaymentController::class, 'store'])->name('invoices.payments.store');

    });

    // ---------- Wali Murid ----------
    Route::middleware('role:parent')->prefix('wali')->name('parent.')->group(function () {
        Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');

        Route::get('students/{student}', [ParentStudentDetailController::class, 'show'])->name('students.show');
        Route::get('/link', [LinkController::class, 'create'])->name('link.create');
Route::post('/link', [LinkController::class, 'store'])->name('link.store');
    });
});
