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
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/exercices/grids/chinese', 'chineseGrid')->name('exercice.chinese-grid');
Route::get('/exercices/grids/chinese/{uid}', GenerateGridCNController::class)->name('exercice.chinese-grid.pdf');

Route::view('/exercices/grids/english', 'englishGrid')->name('exercice.english-grid');
Route::get('/exercices/grids/english/pdf', GenerateEnglishGridController::class)->name('exercice.english-grid.pdf');
