<?php

use App\Http\Controllers\SmsController;
use App\Http\Controllers\SmsTransactionController;
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

Route::get('users/export', [UsersController::class, 'export'])->name('user.export.file');

Route::get('users/import', [UsersController::class, 'index'])->name('users.import.file');
Route::post('users/import', [UsersController::class, 'import'])->name('users.import.view');

Route::get('sms/individual', [SmsController::class, 'indexIndividualSMS'])->name('sms.individual.view');
Route::get('/send-sms/{phone}/{message}', [SmsTransactionController::class, 'sendSMS'])->name('sms.send.params');
Route::post('/send-sms/{phone}/{message}', [SmsTransactionController::class, 'sendSMS'])->name('sms.send.params');
