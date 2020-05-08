<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use App\Http\Requests\StoreStudentRequest;
use DateInterval;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

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


	public function showStudentForm(): View
	{
		return view("onboarding.studentForm");
	}


	public function storeStudent(StoreStudentRequest $request): RedirectResponse
	{
		$cache_key = "onboarding:" . Session::getId() . ":student";
		$student = collect($request->all(["fullname", "wechatId"]));
		$student->transform(fn($content) => Crypt::encryptString($content));
		Cache::put($cache_key, $student, new DateInterval("P1DT12H"));
		return redirect()->action([self::class, 'listSchools']);
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
			->get();

		$cards = $courses->map(function (Course $course) use ($school) {
			return [
				"title" => $course->name,
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
				"link" => action([self::class, 'confirmation'], [$course, "{$schedule['day']}:{$schedule['hour']}"]),
			];
		});

		return view("onboarding.choice-list", [
			"cards" => $cards,
			"title" => "Choisissez un horaire",
		]);
	}


	public function confirmation(Course $course): void
	{
		$student = $this->fetchStoredStudent();
	}

	private function fetchStoredStudent(): array
	{
		return Cache::get("onboarding:" . Session::getId() . ":student", [])
			->transform(fn($content) => Crypt::decryptString($content))
			->toArray();
	}
}