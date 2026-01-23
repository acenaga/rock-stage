<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/home-video', [App\Http\Controllers\VideoController::class, 'index'])->name('videos.index');
Route::get('/video/{video}', [App\Http\Controllers\VideoController::class, 'show'])->name('video.detail');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__ . '/settings.php';
