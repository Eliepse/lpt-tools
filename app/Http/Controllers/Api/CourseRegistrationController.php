<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\ReviewRegistrationRequest;
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


	public function review(ReviewRegistrationRequest $request, CourseRegistration $registration)
	{
		if ($request->isReviewed()) {
			$registration->review();
		} else {
			$registration->unreview();
		}

		if ($registration->save()) {
			return $registration;
		}

		return new JsonResponse(["message" => "Could not change the review state."], 409);
	}
}