<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AdminController;

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

    Route::post('/reports/{id}/delete', [ReportController::class, 'deleteFromDashboard'])
        ->name('reports.delete');

    Route::get('/reports/{id}/answer', [AnswerController::class, 'showForm'])
        ->name('verification.answer');

    Route::post('/submit-answer', [AnswerController::class, 'submit'])
        ->name('answers.submit');

    Route::post('/answers/update-status', [AnswerController::class, 'updateStatus'])
        ->name('answers.updateStatus');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    Route::get('/admin/reports', [AdminController::class, 'manageReports'])
        ->name('admin.manageReports');

    Route::delete('/admin/reports/{id}', [AdminController::class, 'deleteReport'])
        ->name('admin.reports.delete');

    Route::get('/admin/users', [AdminController::class, 'manageUsers'])
        ->name('admin.users');

    Route::get('/admin/user-action/{id}', [AdminController::class, 'userAction'])
        ->name('admin.user.action');
});
