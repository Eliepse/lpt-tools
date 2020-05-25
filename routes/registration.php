<?php

use App\Http\Controllers\Onboarding\DownloadPreRegistrationController;
use App\Http\Controllers\Onboarding\OnboardingInfosController;
use App\Http\Controllers\Onboarding\OnboardingSelectionController;
use Illuminate\Support\Facades\Route;

Route::prefix("onboarding/")->group(function () {
	Route::view('/', "onboarding.welcome");
	Route::get('confirm', [OnboardingInfosController::class, 'confirmation']);
	Route::post('confirm', [OnboardingInfosController::class, 'confirm']);
	Route::post('pdf', DownloadPreRegistrationController::class);
	Route::get('student', [OnboardingInfosController::class, 'studentForm']);
	Route::post('student', [OnboardingInfosController::class, 'storeStudent']);
	Route::get('student-contact', [OnboardingInfosController::class, 'studentContactForm']);
	Route::post('student-contact', [OnboardingInfosController::class, 'storeStudentContact']);

	Route::get('schools', [OnboardingSelectionController::class, 'listSchools']);
	Route::get('{course}/schedules', [OnboardingSelectionController::class, 'listSchedules']);
	Route::get('{school}', [OnboardingSelectionController::class, 'listCategories']);
	Route::get('{school}/{categories}', [OnboardingSelectionController::class, 'listCourses']);
	Route::post('{course}/schedules', [OnboardingSelectionController::class, 'storeCourseSchedule']);
});
