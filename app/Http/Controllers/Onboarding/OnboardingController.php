<?php

namespace App\Http\Controllers\Onboarding;

use App\Course;
use App\Http\Requests\StoreStudentRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class OnboardingController
 *
 * @package App\Http\Controllers\Onboarding
 */
final class OnboardingController
{
	public function welcome(): View
	{
		return view("onboarding.welcome");
	}


	public function showStudentForm(): View
	{
		return view("onboarding.studentForm");
	}


	public function storeStudent(StoreStudentRequest $request): RedirectResponse
	{
		$cache_key = "onboarding:" . Session::getId() . ":student";
		$student = collect($request->all(["fullname", "wechatId"]));
		$student->transform(fn($content) => Crypt::encryptString($content));
		Cache::put($cache_key, $student);
		return redirect()->action([self::class, 'listSchools']);
	}


	public function listSchools()
	{
		dd(Cache::get("onboarding:" . Session::getId() . ":student")->transform(fn($content) => Crypt::decryptString($content)));
	}
}