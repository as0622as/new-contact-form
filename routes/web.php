<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\AdminController;



/*
|--------------------------------------------------------------------------
| Contact
|--------------------------------------------------------------------------
*/
// 管理画面
Route::prefix('admin')
    ->name('admin.')
    ->group(function () {


        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('dashboard');

        Route::get('/', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::delete('delete/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
        Route::get('search', [AdminContactController::class, 'search'])->name('contacts.search');
        Route::get('show/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');

    });



// 入力画面
Route::get('/', [ContactController::class, 'create'])->name('contacts.create');

// 確認画面
Route::post('/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');

// 送信
Route::post('/', [ContactController::class, 'store'])->name('contacts.store');

//サンクス
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contacts.thanks');

// 検索
Route::get('/search', [ContactController::class, 'search'])->name('contacts.search');

// 削除
Route::post('/delete', [ContactController::class, 'destroy'])->name('contacts.destroy');



// Auth関連
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);

