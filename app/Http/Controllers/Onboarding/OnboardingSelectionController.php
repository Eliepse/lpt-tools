<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;

final class OnboardingSelectionController extends OnboardingController
{
	public function listSchools(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
	{
		$schools = Course::query()
			->groupBy("school")
			->get("school")
			->pluck("school");

		return view("onboarding.courses.schools", ["schools" => $schools]);
	}


	public function listCategories(string $school): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
	{
		$categories = Course::query()
			->where("school", $school)
			->groupBy("category")
			->get("category")
			->pluck("category");


		// We order results according to the order set in translation file
		$categoriesOrder = array_flip(array_keys(trans("onboarding.categories")));
		$sortedCategories = array_combine(
			$categories->toArray(),
			array_map(fn($name) => $categoriesOrder[$name] ?? 9999, $categories->toArray())
		);
		asort($sortedCategories);

		return view("onboarding.courses.categories", ["school" => $school, "categories" => array_keys($sortedCategories)]);
	}


	public function listCourses(string $school, string $category): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
	{
		$courses = Course::query()
			->where("school", $school)
			->where("category", $category)
			->get(["id", "name", "description", "price", "price_denominator", "duration_denominator", "duration", "schedules"]);

		return view("onboarding.courses.courses", ["school" => $school, "category" => $category, "courses" => $courses]);
	}
}