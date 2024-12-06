<?php

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::get('users/export', [UsersController::class, 'export']);

Route::get('users/import', [UsersController::class, 'index'])->name('users.import');
Route::post('users/import', [UsersController::class, 'import'])->name('users.import');
