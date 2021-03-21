<?php

namespace App\Mail;

use App\Course;
use App\Models\CourseRegistration;
use Eliepse\LptLayoutPDF\GeneratePreRegistration;
use Eliepse\LptLayoutPDF\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Mpdf\Output\Destination;

final class SendOnboardingMail extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;


	public function __construct(
		private Course $course,
		private Student $student,
		private array $schedule,
		private CourseRegistration $registration
	)
	{
	}


	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build(): SendOnboardingMail
	{
		return $this->subject("[LPT] New registration")
			->view("mails.new-onboarding", ["registration" => $this->registration]);
	}
}
