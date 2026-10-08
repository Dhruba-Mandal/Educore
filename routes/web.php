<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\admin\FacultyController;



// ================================
// ROLE SELECTION
// ================================

Route::get('/', function () {
    return view('role-selection');
})->name('role.selection');


// ================================
// ADMINISTRATOR AUTHENTICATION
// ================================

Route::get('/admin/login', [AdminAuthController::class, 'adminShowLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.submit');

Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');


// // ================================
// // FACULTY AUTHENTICATION
// // ================================

Route::get('/faculty/login', [AdminAuthController::class, 'facultyShowLogin'])
    ->name('faculty.login');

Route::post('/faculty/login', [AdminAuthController::class, 'login'])
    ->name('faculty.login.submit');

Route::post('/faculty/logout', [AdminAuthController::class, 'logout'])
    ->name('faculty.logout');


// ================================
// ADMIN DASHBOARD
// ================================

Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

/*
// |--------------------------------------------------------------------------
// | Admin Menu Pages
// |--------------------------------------------------------------------------
// */

Route::get('/admin/students', [AdminAuthController::class, 'students'])
    ->name('admin.students');

Route::get('/admin/faculty', [AdminAuthController::class, 'faculty'])
    ->name('admin.faculty');

Route::get('/admin/departments', [AdminAuthController::class, 'departments'])
    ->name('admin.departments');

Route::get('/admin/courses', [AdminAuthController::class, 'courses'])
    ->name('admin.courses.index');

Route::get('/admin/subjects', [AdminAuthController::class, 'subjects'])
    ->name('admin.subjects');

Route::get('/admin/attendance', [AdminAuthController::class, 'attendance'])
    ->name('admin.attendance');

Route::get('/admin/assignments', [AdminAuthController::class, 'assignments'])
    ->name('admin.assignments');

Route::get('/admin/examinations', [AdminAuthController::class, 'examinations'])
    ->name('admin.examinations');

Route::get('/admin/results', [AdminAuthController::class, 'results'])
    ->name('admin.results');

Route::get('/admin/timetable', [AdminAuthController::class, 'timetable'])
    ->name('admin.timetable');

Route::get('/admin/notices', [AdminAuthController::class, 'notices'])
    ->name('admin.notices');

Route::get('/admin/reports', [AdminAuthController::class, 'reports'])
    ->name('admin.reports');

Route::get('/admin/settings', [AdminAuthController::class, 'settings'])
    ->name('admin.settings');

// ================================
//Faculty, Student DASHBOARD
// ================================

// Student Login - temporary
Route::get('/student/login', function () {
    return view('student.login');
})->name('student.login');


/*
|--------------------------------------------------------------------------
| Admin Departments
|--------------------------------------------------------------------------
*/

Route::get('/admin/departments', [
    DepartmentController::class,
    'index'
])->name('admin.departments');

Route::get('/admin/departments/create', [
    DepartmentController::class,
    'create'
])->name('admin.departments.create');

Route::post('/admin/departments', [
    DepartmentController::class,
    'store'
])->name('admin.departments.store');

Route::get('/admin/departments/{department}', [
    DepartmentController::class,
    'show'
])->name('admin.departments.show');

Route::get('/admin/departments/{department}/edit', [
    DepartmentController::class,
    'edit'
])->name('admin.departments.edit');

Route::put('/admin/departments/{department}', [
    DepartmentController::class,
    'update'
])->name('admin.departments.update');

Route::delete('/admin/departments/{department}', [
    DepartmentController::class,
    'destroy'
])->name('admin.departments.destroy');



/*
|--------------------------------------------------------------------------
| Admin Subjects
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/subjects',
    [SubjectController::class, 'index']
)->name('admin.subjects');

Route::get(
    '/admin/subjects/create',
    [SubjectController::class, 'create']
)->name('admin.subjects.create');

Route::post(
    '/admin/subjects',
    [SubjectController::class, 'store']
)->name('admin.subjects.store');

Route::get(
    '/admin/subjects/{id}',
    [SubjectController::class, 'show']
)->name('admin.subjects.show');

Route::get(
    '/admin/subjects/{id}/edit',
    [SubjectController::class, 'edit']
)->name('admin.subjects.edit');

Route::put(
    '/admin/subjects/{id}',
    [SubjectController::class, 'update']
)->name('admin.subjects.update');

Route::delete(
    '/admin/subjects/{id}',
    [SubjectController::class, 'destroy']
)->name('admin.subjects.destroy');




/*
|--------------------------------------------------------------------------
| Course Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Course list
    Route::get('/courses', [CourseController::class, 'index'])
        ->name('courses.index');

    // Add course form
    Route::get('/courses/create', [CourseController::class, 'create'])
        ->name('courses.create');

    // Store course
    Route::post('/courses', [CourseController::class, 'store'])
        ->name('courses.store');

    // Show course
    Route::get('/courses/{id}', [CourseController::class, 'show'])
    ->name('courses.show');

    // Edit course
    Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])
        ->name('courses.edit');

    // Update course
    Route::put('/courses/{id}', [CourseController::class, 'update'])
        ->name('courses.update');

    // Delete course
    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])
        ->name('courses.destroy');

    // Fetch subjects according to department
    Route::get('/courses/subjects/{department_id}', [CourseController::class, 'getSubjects'])
        ->name('courses.subjects');
});



/*
|--------------------------------------------------------------------------
| Admin Faculty
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/faculty',
    [FacultyController::class, 'index']
)->name('admin.faculty');

Route::get(
    '/admin/faculty/create',
    [FacultyController::class, 'create']
)->name('admin.faculty.create');

Route::post(
    '/admin/faculty',
    [FacultyController::class, 'store']
)->name('admin.faculty.store');

Route::get(
    '/admin/faculty/{id}',
    [FacultyController::class, 'show']
)->name('admin.faculty.show');

Route::get(
    '/admin/faculty/{id}/edit',
    [FacultyController::class, 'edit']
)->name('admin.faculty.edit');

Route::put(
    '/admin/faculty/{id}',
    [FacultyController::class, 'update']
)->name('admin.faculty.update');

Route::delete(
    '/admin/faculty/{id}',
    [FacultyController::class, 'destroy']
)->name('admin.faculty.destroy');