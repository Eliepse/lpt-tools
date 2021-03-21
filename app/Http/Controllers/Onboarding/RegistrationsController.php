<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use App\Http\Controllers\Controller;
use App\Models\CourseRegistration;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

final class RegistrationsController extends Controller
{
	public function __construct()
	{
		$this->middleware("auth");
	}


	public function show(Course $course)
	{

	}


	public function index(): Factory|View|Application
	{
		return view("admin.registration-index", [
			"registrations" => CourseRegistration::all(),
		]);
	}
}