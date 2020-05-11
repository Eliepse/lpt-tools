<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use App\Http\Requests\StoreStudentRequest;
use DateInterval;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class OnboardingController
 *
 * @package App\Http\Controllers\Onboarding
 */
final class OnboardingController
{
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
		$data = $this->fetchCachedData();
		[$schedule_day, $schedule_hour] = explode(":", $schedule);

		throw_unless($course->schedules->has($schedule_day), new HttpException(422));
		throw_unless(in_array(intval($schedule_hour), $course->schedules[ $schedule_day ]), new HttpException(422));

		Cache::put(
			"onboarding:" . Session::getId() . ":onboarding",
			[
				"student" => [],
				"course_id" => $course->id,
				"schedule_day" => $schedule_day,
				"schedule_hour" => $schedule_hour,
			],
			new DateInterval("P1DT12H")
		);

		return view("onboarding.studentForm", [
			"student" => !empty($data["student"]) ? $data["student"] : null,
			"course" => $course,
			"schedule" => $schedule,
		]);
	}


	public function storeStudentAndCourseSchedule(StoreStudentRequest $request): RedirectResponse
	{
		$student = collect($request->all(["fullname", "wechatId"]));
		$student["emergency"] = str_replace(" ", "", $request->get("emergency"));
		$student->transform(fn($content) => Crypt::encryptString($content));
		$data = $this->fetchCachedData();
		$data["student"] = $student->toArray();
		Cache::put("onboarding:" . Session::getId() . ":onboarding", $data, new DateInterval("P1DT12H"));

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
		$data = $this->fetchCachedData();
		return view("onboarding.confirm", [
			"student" => $data["student"],
			"course" => Course::query()->findOrFail($data["course_id"]),
			"schedule_day" => $data["schedule_day"],
			"schedule_hour" => $data["schedule_hour"],
		]);
	}


	public function confirm(): RedirectResponse
	{
		dd($this->fetchCachedData());
	}


	public function downloadRegistrationFile(string $school, string $category, Course $course): void
	{
		$student = $this->fetchCachedData();
	}


	private function fetchCachedData(): array
	{
		$data = Cache::get("onboarding:" . Session::getId() . ":onboarding", []);
		$data["student"] = array_map(fn($content) => Crypt::decryptString($content), $data["student"] ?? []);
		return $data;
	}
}