<?php


namespace App\Http\Controllers\Api;


use App\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\JsonResponse;
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
		}

		$course->schedules = $schedules;
		$course->saveOrFail();

		return $course;
	}


	public function store(StoreCourseRequest $request)
	{
		$course = new Course(
			array_map(
				"trim",
				$request->all(["name", "school", "category", "duration", "duration_denominator", "price", "price_denominator"])
			)
		);
		$course->description = $request->get("description", "");
		$course->schedules = $request->get("schedules", []);

		if ($this->isDuplicate($course)) {
			// HTTP "Conflict"
			return response(["message" => "Course already exists."], 409);
		}

		if (! $course->save()) {
			response(["message" => "Could not store the course."], 500);
		}

		// HTTP "Created"
		return response($course, 201);
	}


	public function destroy(Course $course)
	{
		if ($course->delete()) {
			return new JsonResponse(status: 204);
		}

		return new JsonResponse(["message" => "Could not delete the course."], 409);
	}


	/**
	 * Checks in the database if there is at least a record that is more or less similar
	 * to the given course, by looking at some caracteristics (not a full match).
	 *
	 * @param Course $course
	 *
	 * @return bool
	 */
	private function isDuplicate(Course $course): bool
	{
		return Course::query()
			->where("name", $course->name)
			->where("school", $course->school)
			->where("category", $course->category)
			->where("duration", $course->duration)
			->where("duration_denominator", $course->duration_denominator)
			->where("price", $course->price)
			->where("price_denominator", $course->price_denominator)
			->exists();
	}
}