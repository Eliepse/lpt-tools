<?php

use \App\Http\Controllers\Onboarding\OnboardingController;

?>
{{----}}<!doctype html>
<html lang="fr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Inscription - LPT</title>
	<link href="{{ mix("/css/styles.css") }}" rel="stylesheet" type="text/css">
</head>

<body class="page--onboarding page--onboarding-welcome">

<main id="app">
	<div class="container">
		<h1 class="onb__title">Bienvenue dans la pré-inscription des Petits Trilingues</h1>
		<p class="onb__subtitle">Vous êtes prêts&nbsp;?</p>

		<a class="onb-card onb-card--interactive" href="{{ action([OnboardingController::class, 'listSchools']) }}">
			C'est parti&nbsp;!
		</a>
	</div>
</main>

<script src="{{ mix('/js/app.js') }}"></script>

</body>
</html>