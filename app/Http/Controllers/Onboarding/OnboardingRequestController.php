<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use App\Http\Requests\StoreOnboardingRequestRequest;
use App\Mail\SendOnboardingMail;
use App\Models\CourseRegistration;
use Carbon\Carbon;
use Eliepse\LptLayoutPDF\Student;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

final class OnboardingRequestController extends OnboardingController
{
	/**
	 * @param $school
	 * @param $category
	 * @param Course $course
	 * @param $schedule
	 *
	 * @return Application|Factory|\Illuminate\Contracts\View\View
	 * @throws \Throwable
	 */
	public function show($school, $category, Course $course, $schedule): Factory|\Illuminate\Contracts\View\View|Application
	{
		[$type, $key, $hour] = explode("+", $schedule);

		if (! $this->validateSchedule($course, $type, $key, $hour)) {
			abort(404);
		}

		$this->fetchCachedData();

		return view("onboarding.courses.request", [
			"student" => $this->student ?? new Student(),
			"school" => $school,
			"category" => $category,
			"course" => $course,
			"schedule" => $schedule,
		]);
	}


	/**
	 * @param StoreOnboardingRequestRequest $request
	 * @param $school
	 * @param $category
	 * @param Course $course
	 * @param $schedule
	 *
	 * @return Application|Factory|View
	 * @throws \Throwable
	 */
	public function store(StoreOnboardingRequestRequest $request, $school, $category, Course $course, $schedule)
	{
		[$type, $key, $hour] = explode("+", $schedule);

		if (! $this->validateSchedule($course, $type, $key, $hour)) {
			abort(404);
		}

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

		$registration = new CourseRegistration([
			"school" => $school,
			"category" => $category,
			"course" => $this->getCourseInfos($course),
			"schedule" => $this->getScheduleInfos($key, $hour),
			"student" => $this->getStudentInfos($this->student),
			"contact" => $this->getContactInfos($this->student),
		]);
		$registration->save();

		if (config("mail.report_to")) {
			$mail = new SendOnboardingMail($course, $this->student, ["day" => $key, "hour" => $hour], $registration);
			$mail->from("no-reply@eliepse.fr", "LPT Server");
			Mail::to(config("mail.report_to"))->queue($mail);
			Log::info("An onboarding mail has been queued.");
		}

		return view("onboarding.courses.confirmation", [
			"course" => $course,
			"schedule" => $schedule,
		]);
	}


	private function getStudentInfos(Student $student): array
	{
		return [
			"firstname" => $student->firstname,
			"lastname" => $student->lastname,
			"fullname_cn" => $student->fullname_cn,
			"birthday" => $student->born_at,
			"city_code" => $student->city_code,
		];
	}


	private function getContactInfos(Student $student): array
	{
		return [
			"wechat_1" => $student->first_contact_wechat,
			"phone_1" => $student->first_contact_phone,
			"phone_2" => $student->second_contact_phone,
		];
	}


	private function getScheduleInfos(string $key, string $hour): array
	{
		return [
			"days" => $key,
			"hour" => $hour,
		];
	}


	private function getCourseInfos(Course $course): array
	{
		return [
			"name" => $course->name,
			"duration" => $course->duration,
			"duration_denominator" => $course->duration_denominator,
			"price" => $course->price,
			"price_denominator" => $course->price_denominator,
		];
	}
}