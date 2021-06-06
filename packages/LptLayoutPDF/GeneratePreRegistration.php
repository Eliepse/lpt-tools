<?php

namespace Eliepse\LptLayoutPDF;

use App\Course;
use Eliepse\WritingGrid\Utils\Math;
use Illuminate\Support\Facades\View;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;

final class GeneratePreRegistration
{
	private Course $course;
	private Student $student;
	private string $schedule_day;
	private string $schedule_hour;


	/**
	 * GeneratePreOrder constructor.
	 *
	 * @param Course $course
	 * @param Student $student
	 * @param string $schedule_day
	 * @param string $schedule_hour
	 */
	public function __construct(
		Course $course,
		Student $student,
		string $schedule_day,
		string $schedule_hour
	)
	{
		$this->course = $course;
		$this->student = $student;
		$this->schedule_day = $schedule_day;
		$this->schedule_hour = $schedule_hour;
	}


	/**
	 * @return Mpdf
	 * @throws \Mpdf\MpdfException
	 */
	public function __invoke(): Mpdf
	{
		$halfWidth = 297 / 2;
		$data = [
			'student' => $this->student,
			'course' => $this->course,
			'schedule' => [
				"day" => $this->schedule_day,
				"hour" => $this->schedule_hour,
			],
		];

		$mpdf = new Mpdf([
			'mode' => 'utf-8',
			'format' => [210, 297],
			'orientation' => 'L',
			'default_font' => 'sans-serif',
		]);

		$mpdf->shrink_tables_to_fit = 1;
		$mpdf->WriteHTML(View::file(__DIR__ . "/resources/views/head.css", $data, [])->render(), HTMLParserMode::HEADER_CSS);
		$mpdf->WriteFixedPosHTML(
			View::file(__DIR__ . "/resources/views/side-left.blade.php", $data, [])->render(),
			0, 0, $halfWidth, 210
		);
		$mpdf->WriteFixedPosHTML(
			View::file(__DIR__ . "/resources/views/side-right.blade.php", $data, [])->render(),
			$halfWidth, 0, $halfWidth, 210
		);
		$mpdf->Image(base_path("resources/images/logo.png"),
			Math::pxtomm(24),
			Math::pxtomm(16),
			Math::pxtomm(80)
		);
		$mpdf->Image(base_path("resources/images/lpt-QR.jpg"),
			256,
			Math::pxtomm(56),
			Math::pxtomm(88),
		);
		return $mpdf;
	}
}