<?php

namespace App\Http\Controllers\Onboarding;

use App\Http\Requests\StoreStudentContactRequest;
use App\Http\Requests\StoreStudentRequest;
use Carbon\Carbon;
use Eliepse\LptLayoutPDF\Student;
use Illuminate\View\View;
use \Illuminate\Http\RedirectResponse;

final class OnboardingInfosController extends OnboardingController
{
	/**
	 * @return RedirectResponse|View
	 */
	public function studentForm()
	{
		$this->fetchCachedData();
		if (! $this->hasValidCachedCourse()) {
			return redirect()->route("onboarding.welcome");
		}
		return view("onboarding.studentForm", [
			"student" => $this->student ?? new Student(),
			"course" => $this->course,
			"schedule" => $this->schedule,
			"back" => [
				"text" => trans("onboarding.buttons.previous"),
				"link" => action([OnboardingSelectionController::class, "listSchedules"], [$this->course]),
			],
		]);
	}


	/**
	 * @return RedirectResponse|View
	 */
	public function studentContactForm()
	{
		$this->fetchCachedData();
		if (! $this->hasValidCachedCourse()) {
			return redirect()->route("onboarding.welcome");
		}
		if ($this->hasValidCachedStudentInfos()) {
			return redirect()->route("onboarding.student");
		}
		return view("onboarding.studentContactForm", [
			"student" => $this->student,
			"course" => $this->course,
			"schedule" => $this->schedule,
			"back" => [
				"text" => trans("onboarding.buttons.previous"),
				"link" => action([self::class, "studentForm"]),
			],
		]);
	}


	/**
	 * @param StoreStudentRequest $request
	 *
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function storeStudent(StoreStudentRequest $request): RedirectResponse
	{
		$this->fetchCachedData();
		$this->student = $this->student ?? new Student();
		$this->student->firstname = $request->get("firstname");
		$this->student->lastname = $request->get("lastname");
		$this->student->fullname_cn = $request->get("fullname_cn");
		$this->student->born_at = Carbon::createFromFormat("Y-m-d", $request->get("bornAt"));
		$this->student->city_code = $request->get("city_code");
		$this->updateCacheData();

		return redirect()->action([self::class, 'studentContactForm']);
	}


	/**
	 * @param StoreStudentContactRequest $request
	 *
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function storeStudentContact(StoreStudentContactRequest $request): RedirectResponse
	{
		$this->fetchCachedData();
		$this->student->first_contact_wechat = $request->get("first_wechat_id");
		$this->student->first_contact_phone = str_replace(" ", "", $request->get("first_phone"));
		$this->student->second_contact_phone = str_replace(" ", "", $request->get("second_phone"));
		$this->updateCacheData();

		return redirect()->action([self::class, 'confirmation']);
	}


	/**
	 * @return RedirectResponse|View
	 */
	public function confirmation()
	{
		$this->fetchCachedData();
		if (! $this->hasValidCachedCourse()) {
			return redirect()->route("onboarding.welcome");
		}
		if ($this->hasValidCachedStudentInfos()) {
			return redirect()->route("onboarding.student");
		}
		if ($this->hasValidCachedContactInfos()) {
			return redirect()->route("onboarding.student-contact");
		}
		return view("onboarding.confirm", [
			"student" => $this->student,
			"course" => $this->course,
			"schedule" => $this->schedule,
			"back" => [
				"text" => trans("onboarding.buttons.previous"),
				"link" => action([self::class, "studentContactForm"]),
			],
		]);
	}
}