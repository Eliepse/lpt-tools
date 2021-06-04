<?php


namespace App\Http\Controllers\Api;


use App\Models\CourseRegistration;
use Illuminate\Http\JsonResponse;

class CourseRegistrationController
{
	public function index()
	{
		return CourseRegistration::query()->get();
	}


	public function destroy(CourseRegistration $registration)
	{
		if ($registration->delete()) {
			return new JsonResponse(status: 204);
		}

		return new JsonResponse(["message" => "Could not delete the course."], 409);
	}
}