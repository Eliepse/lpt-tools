<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use App\Http\Requests\StoreOnboardingRequestRequest;
use App\Mail\SendOnboardingMail;
use Carbon\Carbon;
use Eliepse\LptLayoutPDF\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
	 * @noinspection PhpUnusedParameterInspection
	 */
	public function show($school, $category, Course $course, $schedule)
	{
		[$day, $hour] = explode(":", $schedule);

		throw_unless(in_array(intval($hour), $course->schedules->get($day, []), true), new HttpException(404));

		$this->fetchCachedData();

		return view("onboarding.courses.request", [
			"student" => $this->student ?? new Student(),
			"course" => $course,
			"schedule" => $schedule,
		]);
	}


	/**
	 * @param StoreOnboardingRequestRequest $request
	 * @param Course $course
	 * @param $schedule
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
	 * @throws \Throwable
	 */
	public function store(StoreOnboardingRequestRequest $request, Course $course, $schedule)
	{
		[$day, $hour] = explode(":", $schedule);

		throw_unless(in_array(intval($hour), $course->schedules->get($day, []), true), new HttpException(404));

		$this->fetchCachedData();
		$this->student = $this->student ?? new Student();
		$this->student->firstname = $request->get("firstname");
		$this->student->lastname = $request->get("lastname");
		$this->student->fullname_cn = $request->get("fullname_cn");
		$this->student->born_at = Carbon::createFromFormat("Y-m-d", $request->get("bornAt"));
		$this->student->city_code = $request->get("city_code");
		$this->student->first_contact_wechat = $request->get("first_wechat_id");
		$this->student->first_contact_phone = str_replace(" ", "", $request->get("first_phone"));
		$this->student->second_contact_phone = str_replace(" ", "", $request->get("second_phone"));
		$this->updateCacheData();

		if (config("mail.report_to")) {
			$mail = new SendOnboardingMail($course, $this->student, ["day" => $day, "hour" => $hour]);
			$mail->from("no-reply@eliepse.fr", "LPT Server");
			Mail::to(config("mail.report_to"))->queue($mail);
			Log::info("An onboarding mail has been queued.");
		}

		return view("onboarding.courses.confirmation", [
			"course" => $course,
			"schedule" => $schedule,
		]);
	}
}