<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use App\Http\Requests\StoreCourseRequest;
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

		return view("onboarding.courses.schools", ["schools" => $schools]);
	}


	public function listCategories(string $school): View
	{
		$categories = Course::query()
			->where("school", $school)
			->groupBy("category")
			->get("category")
			->pluck("category");

		// We order results according to the order set in translation file
		$categories = collect(array_keys(trans("onboarding.categories")))
			->intersect($categories);

		return view("onboarding.courses.categories", ["school" => $school, "categories" => $categories]);
	}


	public function listCourses(string $school, string $category): View
	{
		$courses = Course::query()
			->where("school", $school)
			->where("category", $category)
			->get(["id", "school", "category", "name", "description", "price", "price_denominator", "duration"]);

		$cards = $courses->map(function (Course $course) use ($school) {
			$duration_str = CarbonInterval::minutes($course->duration)
				->cascade()
				->forHumans(["short" => true]);
			$aside = $course->price . "&nbsp;€";
			if ($course->price_denominator) {
				$aside .= "<span class='onb-card__denominator'> / "
					. trans("onboarding.denominators." . $course->price_denominator)
					. "</span>";
			}
			$aside .= "<br><span class='onb-card__duration'>$duration_str</span>";
			return [
				"title" => $course->name,
				"description" => $course->description,
				"aside" => $aside,
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