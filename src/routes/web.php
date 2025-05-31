<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controller\MailController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile/setting', [ProfileController::class, 'show'])->name('profile.setting');
    Route::post('/profile/setting', [ProfileController::class, 'update']);
});

Route::get('/test-mail', [\App\Http\Controllers\MailController::class, 'sendTestMail']);
