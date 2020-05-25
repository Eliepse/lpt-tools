<?php

use \App\Http\Controllers\Onboarding\OnboardingInfosController;

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
	<form class="container" method="POST" action="{{ action([OnboardingInfosController::class, 'storeStudentContact']) }}">
		@csrf
		<h1 class="onb__title">Quel enfant souhaitez-vous inscrire&nbsp;?</h1>
		<div class="cg__layout form" ref="form">

			<div class="form__control @error("first_wechat_id") form__control--invalid @enderror">
				<label class="control__label" for="first_wechat_id">Votre ID wechat</label>
				<input id="first_wechat_id"
				       type="text"
				       name="first_wechat_id"
				       placeholder=""
				       maxlength="32"
				       value="{{ $student->first_contact_wechat ?? old("first_wechat_id") }}"
				>
				@error("first_wechat_id")
				<div class="form__helper">{{$message}}</div>
				@enderror
			</div>

			<div class="form__control @error("first_phone") form__control--invalid @enderror">
				<label class="control__label" for="wechatId">Numéro en cas d'urgence</label>
				<input id="wechatId"
				       type="tel"
				       name="first_phone"
				       placeholder="0490123456"
				       pattern="[+ 0-9()]+"
				       maxlength="17"
				       value="{{ $student->first_contact_phone ?? old("first_phone") }}"
				>
				@error("first_phone")
				<div class="form__helper">{{$message}}</div>
				@enderror
			</div>

			<div class="form__control @error("second_phone") form__control--invalid @enderror">
				<label class="control__label" for="wechatId">Numéro en cas d'urgence</label>
				<input id="wechatId"
				       type="tel"
				       name="second_phone"
				       placeholder="0490123456"
				       pattern="[+ 0-9()]+"
				       maxlength="17"
				       value="{{ $student->second_contact_phone ?? old("second_phone") }}"
				>
				@error("second_phone")
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