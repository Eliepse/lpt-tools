<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class OnboardingController
 *
 * @package App\Http\Controllers\Onboarding
 */
final class OnboardingController
{
	public function welcome()
	{
		return view("onboarding.welcome");
	}


	public function showStudentForm() { }
}