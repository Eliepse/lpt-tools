<?php

namespace App\Mail;

use App\Course;
use Eliepse\LptLayoutPDF\GeneratePreRegistration;
use Eliepse\LptLayoutPDF\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Mpdf\Output\Destination;

class SendOnboardingMail extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;

	private Course $course;
	private Student $student;
	private array $schedule;


	/**
	 * Create a new message instance.
	 *
	 * @param Course $course
	 * @param Student $student
	 * @param array $schedule
	 */
	public function __construct(Course $course, Student $student, array $schedule)
	{
		$this->course = $course;
		$this->student = $student;
		$this->schedule = $schedule;
	}


	/**
	 * Build the message.
	 *
	 * @return $this
	 * @throws \Mpdf\MpdfException
	 */
	public function build()
	{
		$generator = new GeneratePreRegistration(
			$this->course,
			$this->student,
			$this->schedule["day"],
			$this->schedule["hour"]
		);
		$title = "registration-form__" . $this->student->getFullname() . "__" . $this->course->name;
		$pdf = $generator()->Output("$title.pdf", Destination::STRING_RETURN);

		return $this->subject("[LPT] New registration")
			->text("mails.new-onboarding")
			->attachData($pdf, $title, ['mime' => 'application/pdf']);
	}
}
