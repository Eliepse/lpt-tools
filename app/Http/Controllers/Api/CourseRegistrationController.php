<?php


namespace App\Http\Controllers\Api;


use App\Models\CourseRegistration;

class CourseRegistrationController
{
	public function index()
	{
		return CourseRegistration::query()->get();
	}
}