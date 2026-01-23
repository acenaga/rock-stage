<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::get('/videos', [App\Http\Controllers\VideoController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('videos.index');
Route::get('/videos/{video}', [App\Http\Controllers\VideoController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('videos.show');

require __DIR__ . '/settings.php';
