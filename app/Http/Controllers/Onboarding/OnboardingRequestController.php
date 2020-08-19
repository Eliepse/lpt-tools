<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use Eliepse\LptLayoutPDF\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class OnboardingRequestController extends OnboardingController
{
	/**
	 * @param $school
	 * @param $category
	 * @param Course $course
	 * @param $schedule
	 *
	 * @return RedirectResponse|View
	 * @throws \Throwable
	 */
	public function show($school, $category, Course $course, $schedule)
	{
		[$day, $hour] = explode(":", $schedule);

		throw_unless(in_array(intval($hour), $course->schedules->get($day, []), true), new HttpException(404));

		return view("onboarding.courses.request", [
			"student" => $this->student ?? new Student(),
			"course" => $course,
			"schedule" => $schedule,
		]);
	}

	public function store() {}
}