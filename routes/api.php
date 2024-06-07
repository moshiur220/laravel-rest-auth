<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthCookiesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// route is here to test sanctum
Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);
Route::post('login', [AuthCookiesController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('userinfo', [AuthController::class, 'userInfo'])->middleware('auth:sanctum');
Route::get('categories', [CategoryController::class, 'index']);