<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Auth\LoginRegisterController;

use App\Http\Middleware\CustomAuthRedirect;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
Route::post('/books', [BookController::class, 'store'])->name('books.store');
Route::get('/books/edit/{id}', [BookController::class, 'edit'])->name('books.edit');
Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
Route::get('/books/search', [BookController::class, 'search'])->name('books.search');

Route::get('/members', [MemberController::class, 'index'])->name('members.index');
Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
Route::post('/members', [MemberController::class, 'store'])->name('members.store');
Route::get('/members/edit/{id}', [MemberController::class, 'edit'])->name('members.edit');
Route::put('/members/{id}', [MemberController::class, 'update'])->name('members.update');
Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('members.destroy');

// Middleware guest memastikan bahwa 'HANYA PENGGUNA YANG BELUM LOGIN' yang dapat mengakses rute atau aksi tertentu.
Route::controller(LoginRegisterController::class)->middleware('guest')->group(function () {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
});

// Dibuat dengan php artisan make:middleware CustomAuthRedirect
// Middleware CustomAuthRedirect memastikan bahwa 'HANYA PENGGUNA YANG SUDAH LOGIN' yang dapat mengakses rute atau aksi tertentu.
Route::middleware([CustomAuthRedirect::class])->group(function () {
    Route::get('/dashboard', [LoginRegisterController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');
});
