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

final class SendOnboardingMail extends Mailable implements ShouldQueue
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
	 */
	public function build(): SendOnboardingMail
	{
		return $this->subject("[LPT] New registration")
			->view("mails.new-onboarding");
	}
}
