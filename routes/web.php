<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('user.dashboard');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [ReportController::class, 'dashboard'])
        ->name('user.dashboard');

    Route::get('/reports/create', [ReportController::class, 'create'])
        ->name('reports.create');

    Route::post('/reports', [ReportController::class, 'store'])
        ->name('reports.store');

    Route::get('/my-reports', [ReportController::class, 'myReports'])
        ->name('reports.my');

    Route::get('/reports/{id}', [ReportController::class, 'show'])
        ->name('reports.show');

    Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])
        ->name('reports.edit');

    Route::put('/reports/{id}', [ReportController::class, 'update'])
        ->name('reports.update');

    Route::delete('/reports/{id}', [ReportController::class, 'destroy'])
        ->name('reports.destroy');

    Route::post('/reports/{id}/resolve', [ReportController::class, 'markResolved'])
        ->name('reports.resolve');

    Route::get('/reports/{id}/answer', [AnswerController::class, 'showForm'])
        ->name('verification.answer');

    Route::post('/submit-answer', [AnswerController::class, 'submit'])
        ->name('answers.submit');

    Route::post('/answers/update-status', [AnswerController::class, 'updateStatus'])
        ->name('answers.updateStatus');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])
            ->name('dashboard');

        Route::get('/reports', [AdminController::class, 'manageReports'])
            ->name('manageReports');

        Route::delete('/reports/{id}', [AdminController::class, 'deleteReport'])
            ->name('reports.delete');

        Route::get('/users', [AdminController::class, 'manageUsers'])
            ->name('users');

        Route::post('/user-action/{id}', [AdminController::class, 'userAction'])
            ->name('user.action');
    });
});
