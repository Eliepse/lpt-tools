<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use App\Http\Requests\CreateRequestRequest;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class OnboardingRequestController extends OnboardingController
{
	/**
	 * @param CreateRequestRequest $request
	 *
	 * @return RedirectResponse
	 * @throws \Throwable
	 */
	public function createRequest(CreateRequestRequest $request): RedirectResponse
	{
		$course = Course::query()->findOrFail($request->get("course_id"));
		$day = $request->get("day");
		$hour = $request->get("hour");

		throw_unless($course->schedules->has($day), new HttpException(422));
		throw_unless(in_array(intval($hour), $course->schedules[ $day ]), new HttpException(422));

		$this->fetchCachedData();
		$this->course = $course;
		$this->schedule = ["day" => $day, "hour" => $hour];
		$this->updateCacheData();

		return redirect()->action([OnboardingInfosController::class, "studentForm"]);
	}
}