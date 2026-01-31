<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('/videos', [App\Http\Controllers\VideoController::class, 'index'])
    ->name('videos.index');
// ->middleware(['auth', 'verified'])
Route::get('/videos/{video}', [App\Http\Controllers\VideoController::class, 'show'])
    ->name('videos.show');
// ->middleware(['auth', 'verified'])

require __DIR__.'/settings.php';
