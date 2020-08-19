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
	public function confirmation()
	{
		$this->fetchCachedData();
		if (! $this->hasValidCachedStudentInfos()) {
			return redirect()->route("onboarding.student");
		}
		if (! $this->hasValidCachedContactInfos()) {
			return redirect()->route("onboarding.student-contact");
		}
		return view("onboarding.confirm", [
			"student" => $this->student,
			"back" => [
				"text" => trans("onboarding.buttons.previous"),
				"link" => action([self::class, "studentContactForm"]),
			],
		]);
	}
}