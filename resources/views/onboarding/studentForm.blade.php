<?php

use \App\Http\Controllers\Onboarding\OnboardingController;

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

<body class="page--onboarding">

<main id="app">
	<form class="container" method="POST" action="{{ action([OnboardingController::class, 'storeStudentAndCourseSchedule']) }}">
		@csrf
		<h1 class="onb__title">Quel enfant souhaitez-vous inscrire&nbsp;?</h1>
		<div class="cg__layout form" ref="form">
			<div class="form__control @error("fullname") form__control--invalid @enderror">
				<label class="control__label" for="fullname">Nom et prénom</label>
				<input id="fullname"
				       type="text"
				       name="fullname"
				       placeholder=""
				       maxlength="32"
				       required
				       autofocus
				       value="{{ $student->fullname_cn ?? old("fullname") }}"
				>
				@error("fullname")
				<div class="form__helper">{{$message}}</div>
				@enderror
			</div>
			<div class="form__control @error("wechatId") form__control--invalid @enderror">
				<label class="control__label" for="wechatId">Votre ID wechat</label>
				<input id="wechatId"
				       type="text"
				       name="wechatId"
				       placeholder=""
				       maxlength="32"
				       value="{{ $student->first_contact_wechat ?? old("wechatId") }}"
				>
				@error("wechatId")
				<div class="form__helper">{{$message}}</div>
				@enderror
			</div>
			<div class="form__control @error("emergency") form__control--invalid @enderror">
				<label class="control__label" for="wechatId">Numéro en cas d'urgence</label>
				<input id="wechatId"
				       type="tel"
				       name="emergency"
				       placeholder="0490123456"
				       maxlength="17"
				       value="{{ $student->first_contact_phone ?? old("emergency") }}"
				>
				@error("emergency")
				<div class="form__helper">{{$message}}</div>
				@enderror
			</div>
		</div>
		<button type="submit">Continuer</button>
	</form>
</main>

<script src="{{ mix('/js/app.js') }}"></script>

</body>
</html>