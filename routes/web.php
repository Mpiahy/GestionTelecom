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

// Login 
Route::get('/loginGuest', [\App\Http\Controllers\LoginController::class,'loginGuestView'])->name('auth.loginGuest');

// Check login
Route::post('/loginCheck', [\App\Http\Controllers\LoginController::class,'loginCheck'])->name('auth.loginCheck');

// Logout
Route::get('/logout', [\App\Http\Controllers\LoginController::class,'logout'])->name('auth.logout');

// Page d'accueil
Route::get('/index', [\App\Http\Controllers\IndexController::class,'indexView'])->middleware('check.session')->name('index');

// Page Référentiels -> Utilisateur
Route::get('/user', [\App\Http\Controllers\UserController::class,'userView'])->middleware('check.session')->name('ref.user');

// Page Référentiels -> Chantier
Route::get('/chantier', [\App\Http\Controllers\ChantierController::class,'chantierView'])->middleware('check.session')->name('ref.chantier');

// Page Référentiels -> Opérateur
Route::get('/operateur', [\App\Http\Controllers\OperateurController::class,'operateurView'])->middleware('check.session')->name('ref.operateur');

// Page Référentiels -> Ligne
Route::get('/ligne', [\App\Http\Controllers\LigneController::class,'ligneView'])->middleware('check.session')->name('ref.ligne');

// Page Référentiels -> Fibre optique
Route::get('/fibre', [\App\Http\Controllers\FibreController::class,'fibreView'])->middleware('check.session')->name('ref.fibre');

// Page Référentiels -> Téléphone
Route::get('/phone', [\App\Http\Controllers\PhoneController::class,'phoneView'])->middleware('check.session')->name('ref.phone');

// Page Référentiels -> Box
Route::get('/box', [\App\Http\Controllers\BoxController::class,'boxView'])->middleware('check.session')->name('ref.box');

// Page Référentiels -> Utilisateur
Route::get('/forfait', [\App\Http\Controllers\ForfaitController::class,'forfaitView'])->middleware('check.session')->name('ref.forfait');