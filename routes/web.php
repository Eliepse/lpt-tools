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

use App\Http\Controllers\GenerateChineseGridController;
use App\Http\Controllers\GenerateEnglishGridController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/workingGrid', 'workingGrid')->name('workingGrid');
Route::get('/workingGrid/pdf', GenerateChineseGridController::class)->name('workingGrid.pdf');

Route::view('/englishGrid', 'englishGrid')->name('englishGrid');
Route::get('/englishGrid/pdf', GenerateEnglishGridController::class)->name('englishGrid.pdf');
