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

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/workingGrid', 'workingGrid')->name('workingGrid');
Route::get('/workingGrid/pdf', [PDFController::class, 'workingGridPDF'])->name('workingGrid.pdf');

Route::get('/workingGrid/pdf', 'PDFController@workingGridPDF')->name('workingGrid.pdf');
