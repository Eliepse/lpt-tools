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

final class OnboardingInfosController extends OnboardingController
{
	public function welcome(): View
	{
		return view("onboarding.welcome");
	}


	/**
	 * @param Course $course
	 * @param string $schedule
	 *
	 * @return View
	 * @throws \Throwable
	 */
	public function studentForm(): View
	{
		$this->fetchCachedData();
		return view("onboarding.studentForm", [
			"student" => $this->student,
			"course" => $this->course,
			"schedule" => $this->schedule,
		]);
	}

//	public function storeStudent(): \Illuminate\Http\RedirectResponse {}

	/**
	 * @param StoreStudentRequest $request
	 *
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function storeStudent(StoreStudentRequest $request): RedirectResponse
	{
		$this->fetchCachedData();
		$this->student = new Student();
		$this->student->fullname_cn = $request->get("fullname");
		$this->student->first_contact_wechat = $request->get("wechatId");
		$this->student->first_contact_phone = str_replace(" ", "", $request->get("emergency"));
		$this->updateCacheData();

		return redirect()->action([self::class, 'confirmation']);
	}


	public function confirmation(): View
	{
		$this->fetchCachedData();
		return view("onboarding.confirm", [
			"student" => $this->student,
			"course" => $this->course,
			"schedule" => $this->schedule,
		]);
	}
}