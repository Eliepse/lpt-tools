<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use Illuminate\View\View;

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
			->get(["id", "name", "description", "price", "price_denominator", "duration", "schedules"]);

		return view("onboarding.courses.courses", ["school" => $school, "category" => $category, "courses" => $courses]);
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
}