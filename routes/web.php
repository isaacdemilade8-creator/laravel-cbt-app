<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Teacher\ExamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {
    Route::get('/exams/{exam}', [StudentController::class, 'show'])
        ->name('student.exams.show');
    Route::post('/exams/{exam}/submit', [StudentController::class, 'submit'])
        ->name('student.exams.submit');
    Route::post('/exams/{exam}/tab-switch', [StudentController::class, 'recordTabSwitch'])
        ->name('student.exams.tab-switch');
    Route::get('/results/{attempt}', [StudentController::class, 'result'])
        ->name('student.results');
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/leaderboard', [App\Http\Controllers\StudentController::class, 'leaderboard'])->name('leaderboard');
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->group(function () {
    Route::get('/exams', [ExamController::class, 'index'])->name('teacher.exams.index');
    Route::get('/exams/create', [ExamController::class, 'create'])->name('teacher.exams.create');
    Route::post('/exams', [ExamController::class, 'store'])->name('teacher.exams.store');
    Route::get('/exams/{exam}/questions/create', [ExamController::class, 'createQuestion'])
        ->name('teacher.exams.questions.create');
    Route::post('/exams/{exam}/questions', [ExamController::class, 'storeQuestion'])
        ->name('teacher.exams.questions.store');
});

Route::middleware(['auth', 'role:admin'])
    ->get('/admin/dashboard', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

require __DIR__.'/auth.php';
