<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use App\Http\Requests\StoreCourseRequest;
use Carbon\CarbonInterface;
use Carbon\CarbonInterval;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

final class OnboardingSelectionController extends OnboardingController
{
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
			"title" => trans("onboarding.titles.choose-school"),
			"back" => [
				"text" => trans("onboarding.buttons.previous"),
				"link" => route("onboarding.welcome"),
			],
		]);
	}


	public function listCategories(string $school): View
	{
		$available_categories = Course::query()
			->where("school", $school)
			->groupBy("category")
			->get("category")
			->pluck("category");

		// We order results according to the order set in translation file
		$available_categories = collect(array_keys(trans("onboarding.categories")))
			->intersect($available_categories);

		$cards = $available_categories->map(function ($name) use ($school) {
			return [
				"title" => trans("onboarding.categories." . $name),
				"link" => action([self::class, 'listCourses'], [$school, $name], false),
			];
		});

		return view("onboarding.choice-list", [
			"cards" => $cards,
			"title" => trans("onboarding.titles.choose-category"),
			"back" => [
				"text" => trans("onboarding.buttons.previous"),
				"link" => action([self::class, "listSchools"]),
			],
		]);
	}


	public function listCourses(string $school, string $category): View
	{
		$courses = Course::query()
			->where("school", $school)
			->where("category", $category)
			->get(["id", "school", "category", "name", "description", "price", "duration"]);

		$cards = $courses->map(function (Course $course) use ($school) {
			$duration = CarbonInterval::minutes($course->duration)->cascade();
			$duration_str = $duration->forHumans(["short" => true]);
			return [
				"title" => $course->name,
				"description" => $course->description,
				"aside" => $course->price . "&nbsp;€<br><span class='onb-card__duration'>$duration_str</span>",
				"link" => action([self::class, 'listSchedules'], [$course]),
			];
		});

		return view("onboarding.choice-list", [
			"cards" => $cards,
			"title" => trans("onboarding.titles.choose-course"),
			"back" => [
				"text" => trans("onboarding.buttons.previous"),
				"link" => action([self::class, "listCategories"], [$school]),
			],
		]);
	}


	public function listSchedules(Course $course): View
	{
		return view("onboarding.select-course-schedule", [
			"course" => $course,
			"title" => trans("onboarding.titles.choose-schedule"),
			"back" => [
				"text" => trans("onboarding.buttons.previous"),
				"link" => action([self::class, "listCourses"], [$course->school, $course->category]),
			],
		]);
	}


	/**
	 * @param StoreCourseRequest $request
	 * @param Course $course
	 *
	 * @return RedirectResponse
	 * @throws Throwable
	 */
	public function storeCourseSchedule(StoreCourseRequest $request, Course $course): RedirectResponse
	{
		$day = $request->get("day");
		$hour = $request->get("hour");

		throw_unless($course->schedules->has($day), new HttpException(422));
		throw_unless(in_array(intval($hour), $course->schedules[ $day ]), new HttpException(422));

		$this->fetchCachedData();
		$this->course = $course;
		$this->schedule = ["day" => $day, "hour" => $hour];
		$this->updateCacheData();

		return redirect()->action([OnboardingInfosController::class, "studentForm"]);
	}
}