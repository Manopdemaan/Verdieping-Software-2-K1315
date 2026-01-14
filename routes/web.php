<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Jobs\MusicDataSeedJob;

// Job routes
Route::get('/dispatch-music-data-seed-job', function () {
    MusicDataSeedJob::dispatch();
    return 'Job dispatched!';
});

Route::get('/dispatch-job', [JobController::class, 'dispatchJob']);

// Dashboard & profiel routes
Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Controller routes
Route::get('/', [Controller::class, 'index']);
Route::get('/form', [Controller::class, 'showUpdateForm'])->name('update-status-form');
Route::post('/update-status', [Controller::class, 'updateStatus'])->name('update-status');

require __DIR__.'/auth.php';
