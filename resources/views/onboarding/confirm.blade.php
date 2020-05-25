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
		<h1 class="onb__title">Ces informations sont-elle correctes&nbsp;?</h1>

		<ul class="onb-list">
			<li class="onb-card onb-card--full">
				<h2 class="onb-card__title">Cours</h2>
				<div class="onb-card__description">
					École&thinsp;: @lang("onboarding.schools." . $course->school)<br>
					Nom du cours&thinsp;: {{ $course->name }}<br>
					Horaire&thinsp;: @lang("onboarding.days." . $schedule["day"]) - {{ $schedule["hour"] }} h<br>
					Prix&thinsp;: {{ $course->price }} €<br>
				</div>
			</li>
			<li class="onb-card onb-card--full">
				<h2 class="onb-card__title">Étudiant</h2>
				<div class="onb-card__description">
					{{ $student->getFullname() }} @if(!empty($student->fullname_cn))({{ $student->fullname_cn }})@endif<br>
					Date de naissance : {{ $student->born_at->toDateString() }}<br>
					Code postal : {{ $student->city_code }}
				</div>
			</li>
			<li class="onb-card onb-card--full">
				<h2 class="onb-card__title">Contacts</h2>
				<div class="onb-card__description">
					Wechat&nbsp;ID&thinsp;: {{ $student->first_contact_wechat }}<br>
					Contact d'urgence 1&thinsp;: {{ $student->first_contact_phone }}<br>
					Contact d'urgence 2&thinsp;: {{ $student->second_contact_phone }}
				</div>
			</li>
		</ul>

		<button type="submit">Tout est bon&nbsp;!</button>
	</form>
</main>

<script src="{{ mix('/js/app.js') }}"></script>

</body>
</html>