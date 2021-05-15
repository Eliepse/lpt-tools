<?php


namespace App\Http\Controllers\Api;


use App\Course;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Routing\Controller;

class CourseController extends Controller
{
	public function index()
	{
		return Course::query()->get();
	}


	public function update(UpdateCourseRequest $request, Course $course)
	{
		$course->fill(
			$request->all([
				"name",
				"category",
				"duration",
				"price",
				"duration_denominator",
				"price_denominator",
			])
		);

		if ($request->has("description") && ! $request->filled("description")) {
			$course->description = "";
		}

		$schedules = $request->get("schedules", []);

		// We check if the schedule object is valid
		// TODO(elie): move this part to the request validator
		foreach ($schedules as $day => $hours) {
			if (! preg_match("/^(mon|tue|wed|thu|fri|sat|sun)(-(mon|tue|wed|thu|fri|sat|sun))?$/", $day)) {
				return response("Invalid key in schedule object", 400);
			}
			foreach ($hours as $hour) {
				if (! preg_match("/^[0-9]{2}:[0-9]{2}$/", $hour)) {
					return response("Invalid hour in schedule object", 400);
				}
			}

			$course->schedules = $schedules;

			$course->saveOrFail();

			return $course;
		}
	}
}