<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\GenerateGridCNController;
use App\Http\Controllers\GenerateEnglishGridController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Onboarding\RegistrationsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/exercices/grids/chinese', 'chineseGrid')->name('exercice.chinese-grid');
Route::get('/exercices/grids/chinese/{uid}', GenerateGridCNController::class)->name('exercice.chinese-grid.pdf');

Route::view('/exercices/grids/english', 'englishGrid')->name('exercice.english-grid');
Route::get('/exercices/grids/english/pdf', GenerateEnglishGridController::class)->name('exercice.english-grid.pdf');

Auth::routes(["register" => false, "reset" => false]);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard/{path?}', [HomeController::class, 'dashboard'])->where('path', '.*');
Route::get('/registrations', [RegistrationsController::class, 'index'])->name('registrations');
