<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserPaymentController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/api/stages/{stage}/grades', [subjectController::class, 'getGrades']);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth:admin')->name('dashboard');

Route::prefix('dashboard')->middleware('auth:admin')->group(function () {
    Route::get('students', [StudentController::class, 'index'])->name('users.index');
    Route::get('students/{id}', [StudentController::class, 'show'])->name('users.show');
    Route::get('create/students', [StudentController::class, 'create'])->name('users.create');
    Route::post('students', [StudentController::class, 'store'])->name('users.store');
    Route::get('students/{id}/edit', [StudentController::class, 'edit'])->name('users.edit');
    Route::put('students/{id}', [StudentController::class, 'update'])->name('users.update');
    Route::delete('students/{id}', [StudentController::class, 'destroy'])->name('users.destroy');
    Route::get('students/{subject}/{stage}/{grade}', [StudentController::class, 'filterStudents'])->name('users.filter');
    Route::get('/users/archive', [StudentController::class, 'showArchiveRecords'])->name('users.archive');
    Route::post('/users/restore', [StudentController::class, 'restoreArchiveRecords'])->name('users.restore');
});


Route::prefix('dashboard')->middleware('auth:admin')->group(function () {
    Route::get('subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::get('subjects/{id}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
    Route::put('subjects/{id}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('subjects/{id}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
    Route::get('subject/{subject_id}/deatils', [SubjectController::class, 'showSubjectDetails'])->name('subject.details');
});


Route::prefix('payments')->middleware('auth:admin')->group(function () {
    Route::get('/select-subject', [UserPaymentController::class, 'selectSubject'])->name('payments.select-subject');
    Route::get('/{subject}/select-stage', [UserPaymentController::class, 'selectStage'])->name('payments.select-stage');
    Route::get('/{subject}/{stage}/select-grade', [UserPaymentController::class, 'selectGrade'])->name('payments.select-grade');
    Route::get('/{subject}/{stage}/{grade}/students', [UserPaymentController::class, 'showStudents'])->name('payments.show-students');
    Route::get('/{subject}/{stage}/{grade}/{student}/create', [UserPaymentController::class, 'createPayment'])->name('payments.create-payment');
    Route::post('/{subject}/{stage}/{grade}/{student}', [UserPaymentController::class, 'storePayment'])->name('payments.store-payment');
    
    // Additional payment routes
    Route::get('/', [UserPaymentController::class, 'index'])->name('payments.index');
    Route::get('/create', [UserPaymentController::class, 'create'])->name('payments.create');
    Route::post('/', [UserPaymentController::class, 'store'])->name('payments.store');
    Route::get('/{student}/edit', [UserPaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/{payment}', [UserPaymentController::class, 'update'])->name('payments.update');
    Route::delete('/{payment}', [UserPaymentController::class, 'destroy'])->name('payments.destroy');
    Route::get('/unpaid/{subject}/{stage}/{grade}', [UserPaymentController::class, 'unpaidUsers'])
    ->name('payments.unpaid-users');
});

Route::prefix('rates')->middleware(['auth:admin'])->group(function () {
    Route::get('/select-subject', [RateController::class, 'selectSubject'])->name('rates.select-subject');
    Route::get('/{subject}/select-stage', [RateController::class, 'selectStage'])->name('rates.select-stage');
    Route::get('/{subject}/{stage}/select-grade', [RateController::class, 'selectGrade'])->name('rates.select-grade');
    Route::get('/{subject}/{stage}/{grade}/students', [RateController::class, 'showStudents'])->name('rates.show-students');
    Route::get('/{subject}/{stage}/{grade}/{student}/create', [RateController::class, 'create'])->name('rates.create');
    Route::post('/{subject}/{stage}/{grade}/{student}', [RateController::class, 'store'])->name('rates.store');
    Route::delete('/rates/{id}', [RateController::class, 'destroy'])->name('rates.destroy');
});
