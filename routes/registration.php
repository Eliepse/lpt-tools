<?php

use App\Http\Controllers\Onboarding\DownloadRequestPDFController;
use App\Http\Controllers\Onboarding\OnboardingInfosController;
use App\Http\Controllers\Onboarding\OnboardingRequestController;
use App\Http\Controllers\Onboarding\OnboardingSelectionController;
use Illuminate\Support\Facades\Route;

Route::prefix("onboarding/")
	->middleware(["registration.checkOpen:courses"])
	->group(function () {
		Route::view('/', "onboarding.courses.portal")->name("onboarding.welcome");
		Route::get('confirm', [OnboardingInfosController::class, 'confirmation']);
		Route::post('student', [OnboardingInfosController::class, 'storeStudent']);
		Route::get('student-contact', [OnboardingInfosController::class, 'studentContactForm'])->name("onboarding.student-contact");
		Route::post('student-contact', [OnboardingInfosController::class, 'storeStudentContact']);

		Route::get('schools', [OnboardingSelectionController::class, 'listSchools'])->name("onboarding.schools");
		Route::get('{school}', [OnboardingSelectionController::class, 'listCategories'])->name("onboarding.categories");
		Route::get('{school}/{category}', [OnboardingSelectionController::class, 'listCourses'])->name("onboarding.courses");
		Route::post('{course}/{schedule}/request', [OnboardingRequestController::class, 'store']);
		Route::get('{school}/{category}/{course}/{schedule}/request', [OnboardingRequestController::class, 'show'])->name("onboarding.request");
		Route::post('{school}/{category}/{course}/{schedule}/pdf', DownloadRequestPDFController::class);
	});
