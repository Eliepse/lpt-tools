<?php

namespace App\Http\Controllers\Onboarding;

use App\Mail\SendOnboardingMail;
use Eliepse\LptLayoutPDF\GeneratePreRegistration;
use Illuminate\Support\Facades\Mail;
use Mpdf\Output\Destination;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class DownloadPreRegistrationController extends OnboardingController
{
	/**
	 * @return StreamedResponse
	 * @throws \Mpdf\MpdfException
	 */
	public function __invoke()
	{
		$this->fetchCachedData();

		Mail::to("lespetitstrilinguesbelleville@gmail.com")
			->queue(new SendOnboardingMail($this->course, $this->student, $this->schedule));

		$generator = new GeneratePreRegistration(
			$this->course,
			$this->student,
			$this->schedule["day"],
			$this->schedule["hour"]
		);
		$title = "registration-form__" . $this->student->getFullname() . "__" . $this->course->name;
		$pdf = $generator()->Output("$title.pdf", Destination::STRING_RETURN);

		return response()
			->streamDownload(
				function () use ($pdf) { echo $pdf; },
				"$title.pdf",
				["Content-Type" => "application/pdf"]
			);
	}
}