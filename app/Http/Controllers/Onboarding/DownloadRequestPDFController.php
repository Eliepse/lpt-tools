<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use Eliepse\LptLayoutPDF\GeneratePreRegistration;
use Illuminate\Support\Facades\Log;
use Mpdf\Output\Destination;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

final class DownloadRequestPDFController extends OnboardingController
{
	/**
	 * @param $school
	 * @param $category
	 * @param Course $course
	 * @param $schedule
	 *
	 * @return \Illuminate\Http\RedirectResponse|StreamedResponse
	 * @throws \Mpdf\MpdfException
	 * @throws \Throwable
	 */
	public function __invoke($school, $category, Course $course, $schedule)
	{
		[$day, $hour] = explode(":", $schedule);

		throw_unless(in_array(intval($hour), $course->schedules->get($day, []), true), new HttpException(404));

		$this->fetchCachedData();

		if (! $this->hasValidCachedStudent()) {
			return redirect()
				->action(
					[OnboardingRequestController::class, 'show'],
					[$course->school, $course->category, $course, $schedule]
				);
		}

		$generator = new GeneratePreRegistration($course, $this->student, $day, $hour);
		$title = "registration-form__" . $this->student->getFullname() . "__" . $course->name;
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