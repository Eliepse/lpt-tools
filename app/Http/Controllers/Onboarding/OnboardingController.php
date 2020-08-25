<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use Carbon\CarbonInterval;
use Eliepse\LptLayoutPDF\Student;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OnboardingController
{
	protected ?Student $student;


	protected function getCacheId(): string
	{
		if (! session()->has("onboarding:key")) {
			session()->put("onboarding:key", Str::random(16));
		}

		return "onboarding:" . session()->get("onboarding:key");
	}


	/**
	 * @throws \Exception
	 */
	protected function updateCacheData(): void
	{
		Cache::put(
			$this->getCacheId(),
			[
				'student' => Crypt::encrypt($this->student),
			],
			CarbonInterval::create(0, 0, 0, 0, config("session.lifetime"))
		);
	}


	protected function fetchCachedData(): void
	{
		$data = Cache::get($this->getCacheId());
		$this->student = empty($data['student']) ? null : Crypt::decrypt($data['student']);
	}


	protected function hasValidCachedStudent(): bool
	{
		return ! is_null($this->student)
			&& ! empty($this->student->first_contact_wechat)
			&& ! empty($this->student->first_contact_phone)
			&& ! empty($this->student->second_contact_phone)
			&& ! empty($this->student->firstname)
			&& ! empty($this->student->lastname)
			&& ! empty($this->student->fullname_cn)
			&& ! empty($this->student->born_at)
			&& ! empty($this->student->city_code);
	}


	/**
	 * @param Course $course
	 * @param string $day
	 * @param string $hour
	 *
	 * @return bool
	 * @throws \Throwable
	 */
	protected function validateSchedule(Course $course, string $day, string $hour): bool
	{
		// This condition is here for compatibility
		if (strlen($hour) === 2) {
			throw_unless(in_array(intval($hour), $course->schedules->get($day, []), true), new HttpException(404));
			return true;
		}

		throw_unless(in_array($hour, $course->schedules->get($day, []), true), new HttpException(404));
		return true;
	}
}