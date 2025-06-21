<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mypage', [ProfileController::class, 'mypage'])->name('auth.mypage');
    Route::get('/mypage/profile', [ProfileController::class, 'show'])->name('mypage.profile');
    Route::post('/mypage/profile', [ProfileController::class, 'store']);
    Route::get('/items/index', [ItemController::class, 'index'])->name('items.index');
    Route::get('/items/{id}', [ItemController::class, 'show'])->name('items.item');
    Route::post('/items/{id}/comments', [ItemController::class, 'store'])->name('items.comment');
    Route::post('/login', [UserController::class, 'logout'])->name('logout');
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'confirm'])->name('purchase.confirm');
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'editAddress'])->name('address.edit');
});

Route::get('/sell', [ItemController::class, 'create'])->name('items.sell');
Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');

Route::post('/register', [UserController::class, 'storeUser']);
Route::post('/login', [UserController::class, 'loginUser']);

Route::post('/items/{item}/favorite', [ItemController::class, 'favorite'])->name('items.favorite');
Route::post('/items/{item}/unfavorite', [ItemController::class, 'unfavorite'])->name('items.unfavorite');

Route::get('/test-mail', [\App\Http\Controllers\MailController::class, 'sendTestMail']);
