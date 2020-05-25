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
	<form class="container" method="POST" action="{{ action([OnboardingInfosController::class, 'storeStudent']) }}">
		@csrf
		<h1 class="onb__title">Quel enfant souhaitez-vous inscrire&nbsp;?</h1>
		<div class="cg__layout form" ref="form">

			<div class="form__control @error("firstname") form__control--invalid @enderror">
				<label class="control__label" for="firstname">Prénom</label>
				<input id="firstname"
				       type="text"
				       name="firstname"
				       placeholder=""
				       maxlength="32"
				       required
				       value="{{ old("firstname", $student->firstname) }}"
				>
				@error("firstname")
				<div class="form__helper">{{$message}}</div>
				@enderror
			</div>

			<div class="form__control @error("lastname") form__control--invalid @enderror">
				<label class="control__label" for="lastname">Nom</label>
				<input id="lastname"
				       type="text"
				       name="lastname"
				       placeholder=""
				       maxlength="32"
				       required
				       value="{{ old("lastname", $student->lastname) }}"
				>
				@error("lastname")
				<div class="form__helper">{{$message}}</div>
				@enderror
			</div>

			<div class="form__control @error("fullname_cn") form__control--invalid @enderror">
				<label class="control__label" for="fullname_cn">Nom chinois complet</label>
				<input id="fullname_cn"
				       type="text"
				       name="fullname_cn"
				       placeholder=""
				       maxlength="32"
				       required
				       value="{{ old("fullname_cn", $student->fullname_cn) }}"
				>
				@error("fullname_cn")
				<div class="form__helper">{{$message}}</div>
				@enderror
			</div>

			<div class="form__control @error("bornAt") form__control--invalid @enderror">
				<label class="control__label" for="bornAt">Date de naissance</label>
				<input id="bornAt"
				       type="date"
				       name="bornAt"
				       placeholder="YYYY-MM-DD"
				       pattern="\d{4}-\d{2}-\d{2}"
				       max="{{ \Carbon\Carbon::now()->toDateString() }}"
				       value="{{ old("bornAt", optional($student->born_at)->toDateString()) }}"
				>
				@error("bornAt")
				<div class="form__helper">{{$message}}</div>
				@enderror
			</div>

			<div class="form__control @error("city_code") form__control--invalid @enderror">
				<label class="control__label" for="city_code">Code postal de résidence</label>
				<input id="city_code"
				       type="text"
				       name="city_code"
				       placeholder=""
				       maxlength="5"
				       required
				       pattern="\d{5}"
				       title="ex: 93250"
				       value="{{ old("city_code", $student->city_code) }}"
				>
				@error("city_code")
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