<?php
use App\Http\Controllers\Onboarding\OnboardingRequestController;
?>
@extends("onboarding.courses.base")

@section("body-class", "onboarding--request")

@section("header-text")
	<a href="{{ route("onboarding.courses", [$course->school, $course->category]) }}" class="onboarding-header__backBtn">
		<svg xmlns="http://www.w3.org/2000/svg" width="19" height="12" fill="none">
			<path fill-rule="evenodd" d="M.5 6.5c-.3-.3-.3-.8 0-1.1L5.2.7c.3-.3.8-.3 1.1 0s.3.8 0 1.1L2.8 5.3H19v1.5H2.8l3.5 3.5c.3.3.3.8 0 1.1s-.8.3-1.1 0L.5 6.5z" fill="#0da84a"/>
		</svg>
		&nbsp;
		@lang("onboarding.buttons.previous")
	</a>
	<hr>
	<h1 class="onboarding-header__title">_</h1>
@endsection

@section("main")
	<div class="container">
		<form class="onboardingForm" action="{{ action([OnboardingRequestController::class, "store"], [$course, $schedule]) }}" method="post">
			@csrf
			@method("post")
		</form>
	</div>
@endsection