<?php

use \App\Http\Controllers\Onboarding\DownloadPreRegistrationController;

/**
 * @var \Eliepse\LptLayoutPDF\Student $student
 */
?>
{{----}}<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Inscription - LPT</title>
	<link href="{{ mix("/css/styles.css") }}" rel="stylesheet" type="text/css">
</head>

<body class="page--onboarding page--onboarding-confirm">

<main id="app">
	<form class="container" method="POST" action="{{ action(DownloadPreRegistrationController::class) }}">
		@csrf
		<h1 class="onb__title">@lang("onboarding.titles.confirm")</h1>

		<ul class="onb-list">
			<li class="onb-card onb-card--full">
				<h2 class="onb-card__title">@lang("onboarding.course")</h2>
				<div class="onb-card__description">
					@lang("onboarding.school")&thinsp;: @lang("onboarding.schools." . $course->school)<br>
					@lang("onboarding.level")&thinsp;: {{ $course->name }}<br>
					@lang("onboarding.schedule")&thinsp;: @lang("onboarding.days." . $schedule["day"]) - {{ $schedule["hour"] }} h<br>
					@lang("onboarding.price")&thinsp;: {{ $course->price }} €<br>
				</div>
			</li>
			<li class="onb-card onb-card--full">
				<h2 class="onb-card__title">@lang("onboarding.student")</h2>
				<div class="onb-card__description">
					{{ $student->getFullname() }} @if(!empty($student->fullname_cn))({{ $student->fullname_cn }})@endif
					<br>
					@lang("onboarding.form.bornAt") : {{ $student->born_at->toDateString() }}<br>
					@lang("onboarding.form.city-code") : {{ $student->city_code }}
				</div>
			</li>
			<li class="onb-card onb-card--full">
				<h2 class="onb-card__title">@lang("onboarding.contact")</h2>
				<div class="onb-card__description">
					@lang("onboarding.form.wechat_id")&thinsp;: {{ $student->first_contact_wechat }}<br>
					@lang("onboarding.form.phone_emergency")&thinsp;: {{ $student->first_contact_phone }}<br>
					@lang("onboarding.form.phone_emergency2")&thinsp;: {{ $student->second_contact_phone }}
				</div>
			</li>
		</ul>

		<button type="submit">@lang("onboarding.buttons.all-good")</button>
	</form>
</main>

<script src="{{ mix('/js/app.js') }}"></script>

</body>
</html>