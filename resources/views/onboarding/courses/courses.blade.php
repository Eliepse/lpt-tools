<?php
use Carbon\CarbonInterval;
use App\Http\Controllers\Onboarding\OnboardingRequestController;
?>
@extends("onboarding.courses.base")

@section("body-class", "onboarding--courses")

@section("header-text")
	<a href="{{ route("onboarding.categories", [$school]) }}" class="onboarding-header__backBtn">
		<svg xmlns="http://www.w3.org/2000/svg" width="19" height="12" fill="none">
			<path fill-rule="evenodd" d="M.5 6.5c-.3-.3-.3-.8 0-1.1L5.2.7c.3-.3.8-.3 1.1 0s.3.8 0 1.1L2.8 5.3H19v1.5H2.8l3.5 3.5c.3.3.3.8 0 1.1s-.8.3-1.1 0L.5 6.5z" fill="#0da84a"/>
		</svg>
		&nbsp;
		@lang("onboarding.buttons.previous")
	</a>
	<hr>
	<h1 class="onboarding-header__title">@lang("onboarding.our courses", ["category" => trans("onboarding.categories.$category")])</h1>
@endsection

@section("main")
	<div class="container">
		<ul>
			<?php /** @var \App\Course $course */ ?>
			@foreach($courses as $course)
				<li>
					<section class="courseCard">
						<header class="courseCard__header">
							<h2 class="courseCard__title">{{ $course->name }}</h2>
							<div class="courseCard__infos">
								<span class="courseCard__price">{{ $course->price }}&nbsp;€
									<sub> /&nbsp; @lang("onboarding.denominators.{$course->price_denominator}") </sub>
								</span><br>
								<span class="courseCard__duration">
									{{ CarbonInterval::minutes($course->duration)->cascade()->forHumans(["short" => true]) }}
									/&nbsp;@lang("onboarding.denominators.week")</span>
							</div>
						</header>
						<p class="courseCard__description">{!! nl2br($course->description) !!}</p>
						<ul class="courseCard__schedules">
							@foreach($course->schedules as $day => $hours)
								<li>
									<h3>@lang("onboarding.days.$day")</h3>
									<ul>
										@foreach($hours as $hour)
											<li>
												<form action="{{ action([OnboardingRequestController::class, "createRequest"]) }}" method="post">
													@csrf
													@method("post")
													<input name="course_id" value="{{ $course->id }}" hidden>
													<input name="day" value="{{ $day }}" hidden>
													<input name="hour" value="{{ $hour }}" hidden>
													<button class="btn btn-ondboarding btn-ondboarding--small" type="submit">
														{{ $hour }}&nbsp;@lang("onboarding.hour-short")
													</button>
												</form>
											</li>
										@endforeach
									</ul>
								</li>
							@endforeach
						</ul>
					</section>
				</li>
			@endforeach
		</ul>
	</div>
@endsection