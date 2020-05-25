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

final class DownloadPreRegistrationController extends OnboardingController
{
	/**
	 * @return StreamedResponse
	 * @throws \Mpdf\MpdfException
	 */
	public function __invoke()
	{
		$this->fetchCachedData();
		$this->student->firstname = "Yinan";
		$this->student->lastname = "Chai";
		$this->student->born_at = "2003-11-07";
		$this->student->second_contact_phone = "0490726860";
		$this->student->city_code = "92200";

		$generator = new GeneratePreRegistration(
			$this->course,
			$this->student,
			$this->schedule["day"],
			$this->schedule["hour"]
		);
		$title = "registration-form__" . $this->student->getFullname() . "__" . $this->course->name;
		$pdf = $generator()->Output("$title.pdf", Destination::STRING_RETURN);
		return response()
			->streamDownload(function () use ($pdf) { echo $pdf; }, "$title.pdf", ["Content-Type" => "application/pdf"]);
	}
}