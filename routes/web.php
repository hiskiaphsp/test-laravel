<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'=> '/'], function () {
    // Menampilkan halaman login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    // Menangani proses login
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    // Menampilkan halaman register
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');

    // Menangani proses registrasi
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

    // Menangani proses logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('/product', ProductController::class)->middleware('auth');
});
