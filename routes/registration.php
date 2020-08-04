<?php

use App\Http\Controllers\Onboarding\DownloadPreRegistrationController;
use App\Http\Controllers\Onboarding\OnboardingInfosController;
use App\Http\Controllers\Onboarding\OnboardingSelectionController;
use Illuminate\Support\Facades\Route;

Route::prefix("onboarding/")
	->middleware(["registration.checkOpen:courses"])
	->group(function () {
	Route::view('/', "onboarding.courses.portal")->name("onboarding.welcome");
	Route::get('confirm', [OnboardingInfosController::class, 'confirmation']);
	Route::post('pdf', DownloadPreRegistrationController::class);
	Route::get('student', [OnboardingInfosController::class, 'studentForm'])->name("onboarding.student");
	Route::post('student', [OnboardingInfosController::class, 'storeStudent']);
	Route::get('student-contact', [OnboardingInfosController::class, 'studentContactForm'])->name("onboarding.student-contact");
	Route::post('student-contact', [OnboardingInfosController::class, 'storeStudentContact']);

	Route::get('schools', [OnboardingSelectionController::class, 'listSchools'])->name("onboarding.schools");
	Route::get('{course}/schedules', [OnboardingSelectionController::class, 'listSchedules']);
	Route::get('{school}', [OnboardingSelectionController::class, 'listCategories']);
	Route::get('{school}/{categories}', [OnboardingSelectionController::class, 'listCourses']);
	Route::post('{course}/schedules', [OnboardingSelectionController::class, 'storeCourseSchedule']);
});
