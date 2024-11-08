<?php

use Illuminate\Support\Facades\Route;

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

// URL par défaut (in this case: Login)
Route::get('/', [\App\Http\Controllers\LoginController::class,'loginView'])->name('auth.login');
Route::get('/login', [\App\Http\Controllers\LoginController::class,'loginView'])->name('auth.login');

// Check login
Route::post('/loginCheck', [\App\Http\Controllers\LoginController::class,'loginCheck'])->name('auth.loginCheck');

// Logout
Route::get('/logout', [\App\Http\Controllers\LoginController::class,'logout'])->name('auth.logout');

// Page d'accueil
Route::get('/index', [\App\Http\Controllers\IndexController::class,'indexView'])->middleware('check.session')->name('index');