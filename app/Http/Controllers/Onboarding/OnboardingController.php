<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use App\Http\Requests\StoreStudentRequest;
use Carbon\CarbonInterval;
use Eliepse\LptLayoutPDF\GeneratePreRegistration;
use Eliepse\LptLayoutPDF\Student;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Mpdf\Output\Destination;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OnboardingController
{
	protected ?Student $student;
	protected ?Course $course;
	protected array $schedule = [];


	protected function getCacheId(): string
	{
		if (!session()->has("onboarding:key")) {
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
}