<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\AdminController;




Route::prefix('admin')
    ->name('admin.')
    ->middleware('auth')
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('dashboard');

        Route::get('/', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::delete('delete/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
        Route::get('search', [AdminContactController::class, 'search'])->name('contacts.search');
        Route::get('show/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
        Route::get('export', [AdminContactController::class, 'export'])->name('contacts.export');

    });

Route::get('/', [ContactController::class, 'create'])->name('contacts.create');

Route::post('/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');

Route::post('/', [ContactController::class, 'store'])->name('contacts.store');

Route::get('/thanks', [ContactController::class, 'thanks'])->name('contacts.thanks');

Route::get('/search', [ContactController::class, 'search'])->name('contacts.search');

Route::post('/delete', [ContactController::class, 'destroy'])->name('contacts.destroy');


Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);

