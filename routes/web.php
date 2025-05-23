<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PKLController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes(['register' => true]);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Student Routes
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/class/{class}', [StudentController::class, 'byClass'])->name('students.byClass');

    // Teacher Routes
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/subject/{subject}', [TeacherController::class, 'bySubject'])->name('teachers.bySubject');

    // Company Routes
    Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
    Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');

    // PKL Routes (Student and Teacher)
    Route::middleware(['auth', 'role:student'])->group(function () {
        Route::get('/pkl', [PKLController::class, 'studentPkl'])->name('pkl.student');
        Route::post('/pkl/company', [PKLController::class, 'storeCompanyRequest'])->name('pkl.company.request');
        Route::post('/pkl/assign', [PKLController::class, 'assignPkl'])->name('pkl.assign');
    });

    Route::middleware(['auth', 'role:teacher'])->group(function () {
        Route::get('/pkl/teacher', [PKLController::class, 'teacherPkl'])->name('pkl.teacher');
        Route::post('/pkl/approve/{pklAssignment}', [PKLController::class, 'approvePkl'])->name('pkl.approve');
    });
});