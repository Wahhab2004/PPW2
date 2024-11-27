<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\GreetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/greet', [GreetController::class, 'greet'])->name('greet');


Route::get('/gallery', [GalleryController::class, 'indexAPI']);