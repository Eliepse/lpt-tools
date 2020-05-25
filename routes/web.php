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
use App\Http\Controllers\Onboarding\DownloadPreRegistrationController;
use App\Http\Controllers\Onboarding\OnboardingInfosController;
use App\Http\Controllers\Onboarding\OnboardingSelectionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('/exercices/grids/chinese', 'chineseGrid')->name('exercice.chinese-grid');
Route::get('/exercices/grids/chinese/{uid}', GenerateGridCNController::class)->name('exercice.chinese-grid.pdf');

Route::view('/exercices/grids/english', 'englishGrid')->name('exercice.english-grid');
Route::get('/exercices/grids/english/pdf', GenerateEnglishGridController::class)->name('exercice.english-grid.pdf');

Route::view('/onboarding', "onboarding.welcome");
Route::get('/onboarding/confirm', [OnboardingInfosController::class, 'confirmation']);
Route::post('/onboarding/confirm', [OnboardingInfosController::class, 'confirm']);
Route::post('/onboarding/pdf', DownloadPreRegistrationController::class);
Route::get('/onboarding/student', [OnboardingInfosController::class, 'studentForm']);
Route::post('/onboarding/student', [OnboardingInfosController::class, 'storeStudent']);

Route::get('/onboarding/schools', [OnboardingSelectionController::class, 'listSchools']);
Route::get('/onboarding/{course}/schedules', [OnboardingSelectionController::class, 'listSchedules']);
Route::get('/onboarding/{school}', [OnboardingSelectionController::class, 'listCategories']);
Route::get('/onboarding/{school}/{categories}', [OnboardingSelectionController::class, 'listCourses']);
Route::post('/onboarding/{course}/schedules', [OnboardingSelectionController::class, 'storeCourseSchedule']);
