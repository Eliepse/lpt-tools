<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use Carbon\CarbonInterval;
use Eliepse\LptLayoutPDF\Student;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class OnboardingController
{
	protected ?Student $student;
	protected ?Course $course;
	protected array $schedule = [];


	protected function getCacheId(): string
	{
		if (! session()->has("onboarding:key")) {
			session()->put("onboarding:key", Str::random());
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
				'course' => $this->course,
				'schedule' => $this->schedule,
			],
			CarbonInterval::create(0, 0, 0, 0, config("session.lifetime"))
		);
	}


	protected function fetchCachedData(): void
	{
		$data = Cache::get($this->getCacheId());
		$this->student = empty($data['student']) ? null : Crypt::decrypt($data['student']);
		$this->course = $data["course"] ?? null;
		$this->schedule = $data["schedule"] ?? [];
	}


	protected function hasValidCachedCourse(): bool
	{
		return ! is_null($this->course) && is_int($this->course->id);
	}


	protected function hasValidCachedStudentInfos(): bool
	{
		return ! is_null($this->student)
			&& ! empty($this->student->firstname)
			&& ! empty($this->student->lastname)
			&& ! empty($this->student->fullname_cn)
			&& ! empty($this->student->bornAt)
			&& ! empty($this->student->city_code);
	}


	protected function hasValidCachedContactInfos(): bool
	{
		return ! is_null($this->student)
			&& ! empty($this->student->first_wechat_id)
			&& ! empty($this->student->first_phone)
			&& ! empty($this->student->second_phone);
	}
}