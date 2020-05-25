<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use App\Http\Requests\StoreStudentRequest;
use Carbon\CarbonInterval;
use Eliepse\LptLayoutPDF\GeneratePreOrder;
use Eliepse\LptLayoutPDF\Student;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Mpdf\Output\Destination;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class OnboardingController
 *
 * @package App\Http\Controllers\Onboarding
 */
final class OnboardingController
{
	private ?Student $student;
	private ?Course $course;
	private array $schedule = [];


	public function __construct()
	{
//		$this->fetchCachedData();
	}



	public function welcome(): View
	{
		return view("onboarding.welcome");
	}


	/**
	 * @param Course $course
	 * @param string $schedule
	 *
	 * @return View
	 * @throws \Throwable
	 */
	public function showStudentForm(Course $course, string $schedule): View
	{
		[$schedule_day, $schedule_hour] = explode(":", $schedule);

		throw_unless($course->schedules->has($schedule_day), new HttpException(422));
		throw_unless(in_array(intval($schedule_hour), $course->schedules[ $schedule_day ]), new HttpException(422));

		$this->fetchCachedData();
		$this->course = $course;
		$this->schedule = ["day" => $schedule_day, "hour" => $schedule_hour];
		$this->updateCacheData();

		return view("onboarding.studentForm", [
			"student" => $this->student,
			"course" => $this->course,
			"schedule" => $this->schedule,
		]);
	}


	/**
	 * @param StoreStudentRequest $request
	 *
	 * @return RedirectResponse
	 * @throws \Exception
	 */
	public function storeStudentAndCourseSchedule(StoreStudentRequest $request): RedirectResponse
	{
		$this->fetchCachedData();
		$this->student = new Student();
		$this->student->fullname_cn = $request->get("fullname");
		$this->student->first_contact_wechat = $request->get("wechatId");
		$this->student->first_contact_phone = str_replace(" ", "", $request->get("emergency"));

		$this->updateCacheData();

		return redirect()->action([self::class, 'confirmation']);
	}


	public function listSchools(): View
	{
		$schools = Course::query()
			->groupBy("school")
			->get("school")
			->pluck("school");

		$cards = $schools->map(function ($name) {
			return [
				"title" => trans("onboarding.schools." . $name),
				"link" => action([self::class, 'listCategories'], $name, false),
			];
		});

		return view("onboarding.choice-list", [
			"cards" => $cards,
			"title" => "Choisissez une école",
		]);
	}


	public function listCategories(string $school): View
	{
		$categories = Course::query()
			->where("school", $school)
			->groupBy("category")
			->get("category")
			->pluck("category");

		$cards = $categories->map(function ($name) use ($school) {
			return [
				"title" => trans("onboarding.categories." . $name),
				"link" => action([self::class, 'listCourses'], [$school, $name], false),
			];
		});

		return view("onboarding.choice-list", [
			"cards" => $cards,
			"title" => "Choisissez une matière",
		]);
	}


	public function listCourses(string $school, string $category): View
	{
		$courses = Course::query()
			->where("school", $school)
			->where("category", $category)
			->get(["id", "school", "category", "name", "description", "price"]);

		$cards = $courses->map(function (Course $course) use ($school) {
			return [
				"title" => $course->name,
				"description" => $course->description,
				"price" => $course->price,
				"link" => action([self::class, 'listSchedules'], [$course]),
			];
		});

		return view("onboarding.choice-list", [
			"cards" => $cards,
			"title" => "Choisissez un cours",
		]);
	}


	public function listSchedules(Course $course): View
	{
		$schedules = $course->schedules->flatMap(function (array $schedules, string $day) use ($course): array {
			return array_map(fn(string $hour): array => ["day" => $day, "hour" => $hour], $schedules);
		});

		$cards = $schedules->map(function (array $schedule) use ($course): array {
			return [
				"title" => trans("onboarding.days." . $schedule["day"]) . " {$schedule['hour']} h",
				"link" => action([self::class, 'showStudentForm'], [$course, "{$schedule['day']}:{$schedule['hour']}"]),
			];
		});

		return view("onboarding.choice-list", [
			"cards" => $cards,
			"title" => "Choisissez un horaire",
		]);
	}


	public function confirmation(): View
	{
		$this->fetchCachedData();
		return view("onboarding.confirm", [
			"student" => $this->student,
			"course" => $this->course,
			"schedule" => $this->schedule,
		]);
	}


	public function confirm(): RedirectResponse
	{
		dd("confirmed");
	}


	/**
	 * @throws \Mpdf\MpdfException
	 */
	public function downloadRegistrationFile(): Response
	{
		$this->fetchCachedData();
		$this->student->firstname = "Yinan";
		$this->student->lastname = "Chai";
//		$this->student->fullname_cn = "柴轶男";
		$this->student->born_at = "2003-11-07";
//		$this->student->first_contact_phone = "0603260318";
		$this->student->second_contact_phone = "0490726860";
//		$this->student->first_contact_wechat = "eliepse13458795";
		$this->student->city_code = "92200";

		$generator = new GeneratePreOrder(
			$this->course,
			$this->student,
			$this->schedule["day"],
			$this->schedule["hour"]
		);
		$pdf = $generator()->Output('hey.pdf', Destination::STRING_RETURN);
		return response($pdf)->withHeaders(["Content-Type" => "application/pdf"]);
	}


	private function getCacheId(): string
	{
		Log::debug(__FUNCTION__, [session()->get("onboarding:key")]);

		if (!session()->has("onboarding:key")) {
			session()->put("onboarding:key", Str::random());
		}

		return "onboarding:" . session()->get("onboarding:key");
	}


	/**
	 * @throws \Exception
	 */
	private function updateCacheData(): void
	{
		Log::debug(__FUNCTION__, [$this->getCacheId()]);
		Cache::put(
			$this->getCacheId(),
			[
				'student' => Crypt::encrypt($this->student),
				'course' => $this->course,
				'schedule' => $this->schedule,
			],
			CarbonInterval::create(0, 0, 0, 0, config("session.lifetime"))
		);
	}


	private function fetchCachedData(): void
	{
		$data = Cache::get($this->getCacheId());
		Log::debug(__FUNCTION__, [$this->getCacheId()]);
		$this->student = empty($data['student']) ? null : Crypt::decrypt($data['student']);
		$this->course = $data["course"] ?? null;
		$this->schedule = $data["schedule"] ?? [];
	}
}