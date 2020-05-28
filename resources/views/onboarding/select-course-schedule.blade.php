<?php

use \App\Http\Controllers\Onboarding\OnboardingSelectionController;

?>
{{----}}<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Inscription - LPT</title>
	<link href="{{ mix("/css/styles.css") }}" rel="stylesheet" type="text/css">
</head>

<body class="page--onboarding">

<main id="app">
	<div class="container">
		<h1 class="onb__title">{{ $title }}</h1>
		@isset($back)
			<a class="onb-card onb-card--interactive" href="{{ $back["link"] }}">{{ $back["text"] }}</a>
		@endisset
		<ul class="onb-list">
			@foreach($course->schedules as $day => $hours)
				@foreach($hours as $hour)
					<li>
						<form action="{{
							action([OnboardingSelectionController::class, "storeCourseSchedule"], [$course])
						  }}"
						      method="POST"
						>
							@csrf
							<button class="btn onb-card onb-card--interactive onb-card--full">
								<span class="onb-card__title">@lang("onboarding.days." . $day) - {{ $hour }} @lang("onboarding.hour-short")</span>
							</button>
							<input name="day" value="{{ $day }}" hidden>
							<input name="hour" value="{{ $hour }}" hidden>
						</form>
					</li>
				@endforeach
			@endforeach
		</ul>
	</div>
</main>

<script src="{{ mix('/js/app.js') }}"></script>

</body>
</html>