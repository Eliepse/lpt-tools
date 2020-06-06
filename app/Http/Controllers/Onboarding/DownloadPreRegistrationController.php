<?php

namespace App\Http\Controllers\Onboarding;

use App\Mail\SendOnboardingMail;
use Eliepse\LptLayoutPDF\GeneratePreRegistration;
use Illuminate\Support\Facades\Log;
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

		if (config("mail.report_to")) {
			$mail = new SendOnboardingMail($this->course, $this->student, $this->schedule);
			$mail->from("no-reply@eliepse.fr", "LPT Server");
			Mail::to(config("mail.report_to"))->queue($mail);
			Log::info("An onboarding mail has been queued.");
		}

		$generator = new GeneratePreRegistration(
			$this->course,
			$this->student,
			$this->schedule["day"],
			$this->schedule["hour"]
		);
		$title = "registration-form__" . $this->student->getFullname() . "__" . $this->course->name;
		$pdf = $generator()->Output("$title.pdf", Destination::STRING_RETURN);

		Log::info("An onboarding form has been generated.");

		return response()
			->streamDownload(
				function () use ($pdf) { echo $pdf; },
				"$title.pdf",
				["Content-Type" => "application/pdf"]
			);
	}
}